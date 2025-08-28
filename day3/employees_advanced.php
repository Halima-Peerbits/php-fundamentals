<?php
require __DIR__ . '/db.php';

/** -------------------- Inputs -------------------- */
$q        = trim($_GET['q'] ?? '');               // search by name
$dept     = $_GET['dept'] ?? '';                  // filter by department id
$sort     = $_GET['sort'] ?? 'name';              // sort key
$dir      = strtolower($_GET['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';
$page     = max(1, (int)($_GET['page'] ?? 1));    // page number
$perPage  = min(50, max(5, (int)($_GET['perPage'] ?? 5))); // page size (5..50)
$export   = isset($_GET['export']) ? $_GET['export'] : null; // 'csv' to export
$offset   = ($page - 1) * $perPage;

/** -------------------- Sort whitelist -------------------- */
$sortMap = [
    'name'      => 'e.last_name, e.first_name',
    'dept'      => 'd.name',
    'hire_date' => 'e.hire_date',
    'salary'    => 'e.salary'
];
$orderBy = $sortMap[$sort] ?? $sortMap['name'];

/** -------------------- WHERE clause -------------------- */
$where  = [];
$params = [];
if ($q !== '') {
    $where[] = '(e.first_name LIKE :q OR e.last_name LIKE :q)';
    $params[':q'] = "%$q%";
}
if ($dept !== '' && ctype_digit($dept)) {
    $where[] = 'e.department_id = :dept';
    $params[':dept'] = (int)$dept;
}
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

/** -------------------- Total count for pagination -------------------- */
$sqlCount = "
    SELECT COUNT(*) 
    FROM employees e
    JOIN departments d ON d.id = e.department_id
    $whereSql
";
$st = $pdo->prepare($sqlCount);
$st->execute($params);
$total = (int)$st->fetchColumn();
$totalPages = max(1, (int)ceil($total / $perPage));

/** -------------------- Main list (JOIN + ORDER + LIMIT/OFFSET) -------------------- */
$sqlList = "
    SELECT 
        e.id, e.first_name, e.last_name, e.hire_date, e.salary,
        d.name AS department
    FROM employees e
    JOIN departments d ON d.id = e.department_id
    $whereSql
    ORDER BY $orderBy $dir
    LIMIT :limit OFFSET :offset
";
$st = $pdo->prepare($sqlList);
foreach ($params as $k => $v) $st->bindValue($k, $v);
$st->bindValue(':limit',  $perPage, PDO::PARAM_INT);
$st->bindValue(':offset', $offset,  PDO::PARAM_INT);
$st->execute();
$rows = $st->fetchAll();

/** -------------------- Aggregates (GROUP BY) -------------------- */
$aggDeptCount = $pdo->query("
    SELECT d.name AS department, COUNT(*) AS total
    FROM employees e
    JOIN departments d ON d.id = e.department_id
    GROUP BY d.id, d.name
    ORDER BY total DESC, d.name
")->fetchAll();

$aggAvgSalary = $pdo->query("
    SELECT d.name AS department, ROUND(AVG(e.salary), 2) AS avg_salary
    FROM employees e
    JOIN departments d ON d.id = e.department_id
    GROUP BY d.id, d.name
    ORDER BY avg_salary DESC
")->fetchAll();

/** -------------------- Optional: Salary rank (MySQL 8 window function) -------------------- */
$sqlRank = "
    SELECT 
        e.id, CONCAT(e.first_name,' ',e.last_name) AS full_name,
        d.name AS department,
        e.salary,
        DENSE_RANK() OVER (ORDER BY e.salary DESC) AS salary_rank
    FROM employees e
    JOIN departments d ON d.id = e.department_id
    ORDER BY salary_rank, full_name
    LIMIT 10
";
$topSalaries = $pdo->query($sqlRank)->fetchAll();

/** -------------------- Departments for filter -------------------- */
$deps = $pdo->query("SELECT id, name FROM departments ORDER BY name")->fetchAll();

/** -------------------- Helpers -------------------- */
function qs(array $extra = []) {
    $base = $_GET;
    foreach ($extra as $k => $v) {
        if ($v === null) unset($base[$k]); else $base[$k] = $v;
    }
    return htmlspecialchars('?' . http_build_query($base));
}
function nextDir($d) { return strtolower($d) === 'asc' ? 'desc' : 'asc'; }

/** -------------------- CSV Export -------------------- */
if ($export === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="employees.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['ID','First Name','Last Name','Department','Hire Date','Salary']);
    foreach ($rows as $r) {
        fputcsv($out, [
            $r['id'], $r['first_name'], $r['last_name'],
            $r['department'], $r['hire_date'], $r['salary']
        ]);
    }
    fclose($out);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Employee Directory (Advanced)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        .grid { display: grid; grid-template-columns: 1fr; gap: 16px; }
        @media (min-width: 900px) { .grid { grid-template-columns: 2fr 1fr; } }
        .card { border: 1px solid #ddd; border-radius: 10px; padding: 16px; }
        h2 { margin: 0 0 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
        th a { text-decoration: none; }
        .controls { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
        .pill { display: inline-block; background: #f5f5f5; padding: 3px 8px; border-radius: 999px; font-size: 12px; }
        .pagination a, .pagination span { padding: 6px 10px; border: 1px solid #ddd; margin-right: 6px; border-radius: 6px; text-decoration: none; }
        .pagination .active { background: #007bff; color: #fff; border-color: #007bff; }
        .muted { color: #666; }
        .right { text-align: right; }
    </style>
</head>
<body>

<div class="card">
    <h2>🔎 Search, Filter, Sort</h2>
    <form class="controls" method="get">
        <input type="text" name="q" placeholder="Search name…" value="<?= htmlspecialchars($q) ?>">
        <select name="dept">
            <option value="">All departments</option>
            <?php foreach ($deps as $d): ?>
                <option value="<?= $d['id'] ?>" <?= ($dept !== '' && (int)$dept === (int)$d['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Per page:
            <select name="perPage">
                <?php foreach ([5,10,20,50] as $pp): ?>
                    <option value="<?= $pp ?>" <?= $perPage===$pp ? 'selected' : '' ?>><?= $pp ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit">Apply</button>
        <a href="employees_advanced.php">Reset</a>
        <a href="<?= qs(['export'=>'csv']) ?>">Export CSV</a>
        <span class="pill"><?= $total ?> result<?= $total===1?'':'s' ?></span>
    </form>
</div>

<div class="grid">
    <div class="card">
        <h2>📋 Employees</h2>
        <table>
            <thead>
                <tr>
                    <th><a href="<?= qs(['sort'=>'name','dir'=> nextDir($dir)]) ?>">Name</a></th>
                    <th><a href="<?= qs(['sort'=>'dept','dir'=> nextDir($dir)]) ?>">Department</a></th>
                    <th><a href="<?= qs(['sort'=>'hire_date','dir'=> nextDir($dir)]) ?>">Hire Date</a></th>
                    <th class="right"><a href="<?= qs(['sort'=>'salary','dir'=> nextDir($dir)]) ?>">Salary</a></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$rows): ?>
                    <tr><td colspan="4" class="muted">No employees found.</td></tr>
                <?php else: foreach ($rows as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['last_name'] . ', ' . $r['first_name']) ?></td>
                        <td><?= htmlspecialchars($r['department']) ?></td>
                        <td><?= htmlspecialchars($r['hire_date']) ?></td>
                        <td class="right"><?= number_format($r['salary'], 2) ?></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>

        <div class="pagination" style="margin-top:12px;">
            <?php if ($page > 1): ?>
                <a href="<?= qs(['page' => $page - 1]) ?>">« Prev</a>
            <?php endif; ?>

            <?php
            $start = max(1, $page - 2);
            $end   = min($totalPages, $page + 2);
            if ($start > 1) echo '<a href="'.qs(['page'=>1]).'">1</a><span class="muted">…</span>';
            for ($p = $start; $p <= $end; $p++):
                if ($p == $page) echo '<span class="active">'.$p.'</span>';
                else echo '<a href="'.qs(['page'=>$p]).'">'.$p.'</a>';
            endfor;
            if ($end < $totalPages) echo '<span class="muted">…</span><a href="'.qs(['page'=>$totalPages]).'">'.$totalPages.'</a>';
            ?>

            <?php if ($page < $totalPages): ?>
                <a href="<?= qs(['page' => $page + 1]) ?>">Next »</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <h2>📊 Aggregates</h2>

        <h3>Employees per Department</h3>
        <table>
            <thead><tr><th>Department</th><th class="right">Total</th></tr></thead>
            <tbody>
                <?php foreach ($aggDeptCount as $a): ?>
                    <tr>
                        <td><?= htmlspecialchars($a['department']) ?></td>
                        <td class="right"><?= (int)$a['total'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 style="margin-top:16px;">Average Salary per Department</h3>
        <table>
            <thead><tr><th>Department</th><th class="right">Avg Salary</th></tr></thead>
            <tbody>
                <?php foreach ($aggAvgSalary as $a): ?>
                    <tr>
                        <td><?= htmlspecialchars($a['department']) ?></td>
                        <td class="right"><?= number_format($a['avg_salary'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 style="margin-top:16px;">Top Salaries (Rank)</h3>
        <table>
            <thead><tr><th>Name</th><th>Department</th><th class="right">Salary</th><th class="right">Rank</th></tr></thead>
            <tbody>
                <?php foreach ($topSalaries as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['full_name']) ?></td>
                        <td><?= htmlspecialchars($t['department']) ?></td>
                        <td class="right"><?= number_format($t['salary'], 2) ?></td>
                        <td class="right"><?= (int)$t['salary_rank'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="muted" style="margin-top:8px;">(Rank uses MySQL 8 window functions)</p>
    </div>
</div>
</body>
</html>

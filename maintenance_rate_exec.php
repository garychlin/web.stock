<?php
// 获取请求的 JSON 数据
$data = json_decode(file_get_contents('php://input'), true);
$command = $data['command'];
$loan_amount = $data['loanAmount'];

// 使用完整的 Python 路径调用脚本
$output = shell_exec(escapeshellcmd($command)); // 执行命令并获取输出

if ($output === null) {
    die(json_encode(['error' => '無法執行 Python 腳本']));
}

// 处理返回的数据
$prices = json_decode($output, true); // 将 JSON 解析为 PHP 数组
if ($prices) {
    echo json_encode(['prices' => $prices]);
} else {
    echo json_encode(['error' => '無法獲取數據']);
}
?>

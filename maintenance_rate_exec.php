<?php
// 引入股票數據
include 'maintenance_stocks.php'; // 包含股票數據

// 獲取請求的 JSON 數據
$data = json_decode(file_get_contents('php://input'), true);
$loan_amount = $data['loanAmount'];

// 獲取股票代號
$stock_codes = array_column($stocks, 'code'); // 從 $stocks 中提取股票代號
$command = "/usr/local/bin/python /Users/garylin/Projects-Cursor/stock/fetch_stock_twstock.py latest " . implode(' ', $stock_codes);

// 使用完整的 Python 路徑調用腳本
$output = shell_exec(escapeshellcmd($command)); // 執行命令並獲取輸出

if ($output === null) {
    die(json_encode(['error' => '無法執行 Python 腳本']));
}

// 處理返回的數據
$prices = json_decode($output, true); // 將 JSON 解析為 PHP 陣列
if ($prices) {
    echo json_encode(['prices' => $prices]);
} else {
    echo json_encode(['error' => '無法獲取數據']);
}
?>

<?php
// 設定股票代號
$stock_code = '2330'; // 例如台積電的股票代號

// 調用 Python 腳本
$command = escapeshellcmd("python getstock.py {$stock_code}"); // 使用 python 調用腳本
$output = shell_exec($command); // 執行命令並獲取輸出

die("output=".$output);

// 處理返回的數據
$data = json_decode($output, true); // 將 JSON 解析為 PHP 陣列
if ($data) {
    echo "股票代號: " . $data['stock_code'] . "<br>";
    echo "即時股價: " . $data['price'] . "<br>";
} else {
    echo "無法獲取數據";
}
?>

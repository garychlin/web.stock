<?php
// 引入股票數據
include 'maintenance_stocks.php'; // 包含股票數據

// 獲取股票代號
$stock_codes = array_column($stocks, 'code'); // 從 $stocks 中提取股票代號

// 構建 TWSE API URL
$apiUrl = "https://mis.twse.com.tw/stock/api/getStockInfo.jsp?ex_ch=";
$ex_ch_array = []; // 用於存儲每個股票的 ex_ch 參數

foreach ($stocks as $stock) {
    $code = $stock['code'];
    $type = isset($stock['type']) ? $stock['type'] : 'tse'; // 檢查 type 是否存在，預設為 'tse'
    $ex_ch_array[] = "{$type}_{$code}.tw"; // 根據 type 構建 ex_ch 參數
}

$apiUrl .= implode('|', $ex_ch_array); // 將所有的 ex_ch 參數用 | 連接

// 使用 cURL 獲取數據
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// 解析 JSON 數據
$data = json_decode($response, true);

// 檢查 API 回傳的狀態
if ($data['rtcode'] === '0000') {
    $result = [];
    foreach ($stock_codes as $code) {
        $priceData = null; // 預設價格為 null
        foreach ($data['msgArray'] as $stock) {
            if ($stock['c'] === $code) {
                $priceData = [
                    "stock_code" => $code,
                    "price" => isset($stock['z']) ? (float)$stock['z'] : null, // 當日股價，若不存在則為 null
                ];
                break; // 找到對應的股票後跳出內層循環
            }
        }
        // 將每個股票的價格數據添加到結果中
        $result[$code] = $priceData;
    }
    echo json_encode(['prices' => $result]); // 返回 JSON 格式的數據
} else {
    echo json_encode(['error' => $data['rtmessage']]);
}
?>
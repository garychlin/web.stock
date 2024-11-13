import sys
import twstock
import json

# 獲取股票代號
stock_code = sys.argv[1]  # 從命令行參數獲取股票代號

try:
    # 獲取股票資料
    stock = twstock.Stock(stock_code)

    # 獲取即時股價
    price = stock.price

    # 返回 JSON 格式的數據
    data = {
        'stock_code': stock_code,
        'price': price
    }
except Exception as e:
    # 返回錯誤信息
    data = {
        'error': str(e)
    }

print(json.dumps(data))  # 輸出 JSON 數據

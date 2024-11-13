import sys
import twstock
import json

# 獲取股票代號
stock_codes = sys.argv[1:]  # 從命令行參數獲取多個股票代號

# 獲取股票資料
prices = {}
for stock_code in stock_codes:
    try:
        stock = twstock.Stock(stock_code)
        prices[stock_code] = stock.price[-1] if stock.price else None  # 獲取最新股價
    except Exception as e:
        prices[stock_code] = str(e)  # 返回錯誤信息

# 返回 JSON 格式的數據
print(json.dumps(prices))  # 輸出 JSON 數據

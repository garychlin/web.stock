import sys
import twstock
import json

# 獲取股票代號
if len(sys.argv) > 1:
    stock_code = sys.argv[1]
else:
    stock_code = '2330'  # 默認為台積電的股票代號

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

# 确保只输出 JSON 数据，没有其他输出
print(json.dumps(data))  # 輸出 JSON 數據



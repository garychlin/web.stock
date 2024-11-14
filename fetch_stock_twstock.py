import sys
import twstock
import json

# 獲取請求類型和股票代號
if len(sys.argv) > 2:
    request_type = sys.argv[1]  # 'latest' 或 'history'
    stock_codes = sys.argv[2:]  # 股票代號列表
else:
    request_type = 'latest'
    stock_codes = ['2330']  # 默認為台積電的股票代號

data = {}

try:
    for stock_code in stock_codes:
        stock = twstock.Stock(stock_code)

        if request_type == 'latest':
            # 獲取即時股價
            price = stock.price[-1] if stock.price else None  # 只返回最新股價
            data[stock_code] = {
                'stock_code': stock_code,
                'price': price
            }
        elif request_type == 'history':
            # 返回歷史股價
            data[stock_code] = {
                'stock_code': stock_code,
                'price': stock.price
            }
except Exception as e:
    # 返回錯誤信息
    data = {
        'error': str(e)
    }

# 确保只输出 JSON 数据，没有其他输出
print(json.dumps(data))  # 輸出 JSON 數據



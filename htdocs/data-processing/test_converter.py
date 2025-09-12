import pandas as pd
import os
import subprocess

# 创建测试用的Excel文件
def create_test_files():
    # 创建测试用的Excel数据
    excel_data = {
        "序号": [1, 2, 3],
        "商品标题": ["测试商品1", "测试商品2", "测试商品3"],
        "商品ID": ["SKU001", "SKU002", "SKU003"],
        "图片地址": ["http://example.com/image1.jpg", "http://example.com/image2.jpg", "http://example.com/image3.jpg"],
        "商品价格": [99.99, 199.99, 299.99]
    }
    
    # 创建Excel文件
    excel_file = "test_products.xlsx"
    df_excel = pd.DataFrame(excel_data)
    df_excel.to_excel(excel_file, index=False)
    
    # 创建测试用的CSV数据（作为模板）
    csv_data = {
        "ID": ["模板ID"],
        "描述": ["模板描述"],
        "SKU": ["模板SKU"],
        "图片": ["模板图片地址"],
        "常规售价": ["模板价格"],
        "其他列": ["其他值"]
    }
    
    # 创建CSV文件
    csv_file = "test_template.csv"
    df_csv = pd.DataFrame(csv_data)
    df_csv.to_csv(csv_file, index=False, encoding='utf-8-sig')
    
    return excel_file, csv_file

# 运行测试
def run_test():
    print("创建测试文件...")
    excel_file, csv_file = create_test_files()
    
    print(f"已创建测试文件: {excel_file}, {csv_file}")
    
    # 显示创建的测试文件内容
    print("\nExcel测试文件内容:")
    df_excel = pd.read_excel(excel_file)
    print(df_excel)
    
    print("\nCSV测试文件内容:")
    df_csv = pd.read_csv(csv_file)
    print(df_csv)
    
    # 运行主脚本进行转换
    print("\n运行转换脚本...")
    script_path = "convert_excel_to_csv.py"
    
    try:
        # 使用Python运行主脚本
        result = subprocess.run(
            ["python", script_path, excel_file, csv_file],
            capture_output=True,
            text=True,
            check=True
        )
        
        print("\n转换脚本输出:")
        print(result.stdout)
        
        # 显示转换后的CSV文件内容
        print("\n转换后的CSV文件内容:")
        df_converted = pd.read_csv(csv_file)
        print(df_converted)
        
        print("\n测试成功! 数据已成功转换并追加到CSV文件中。")
        
    except subprocess.CalledProcessError as e:
        print(f"\n转换脚本执行失败: {e}")
        print(f"错误输出: {e.stderr}")
    except Exception as e:
        print(f"\n测试过程中发生错误: {e}")
    finally:
        # 清理测试文件
        if os.path.exists(excel_file):
            os.remove(excel_file)
            print(f"\n已删除测试文件: {excel_file}")
        if os.path.exists(csv_file):
            os.remove(csv_file)
            print(f"已删除测试文件: {csv_file}")

if __name__ == "__main__":
    run_test()
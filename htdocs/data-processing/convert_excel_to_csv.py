import pandas as pd
import os
import sys

def convert_excel_to_csv(excel_file_path, csv_file_path):
    """
    将Excel文件中的数据按照指定映射关系追加到CSV文件中
    
    参数:
    excel_file_path: Excel文件路径
    csv_file_path: CSV文件路径
    
    返回:
    bool: 转换是否成功
    """
    try:
        # 检查文件是否存在
        if not os.path.exists(excel_file_path):
            print(f"错误: Excel文件 '{excel_file_path}' 不存在")
            return False
        
        if not os.path.exists(csv_file_path):
            print(f"错误: CSV文件 '{csv_file_path}' 不存在")
            return False
        
        # 读取Excel文件
        df_excel = pd.read_excel(excel_file_path)
        
        # 读取CSV文件
        df_csv = pd.read_csv(csv_file_path)
        
        # 显示Excel文件的列名，帮助用户确认映射关系
        print("Excel文件的列名:")
        for i, col in enumerate(df_excel.columns):
            print(f"{i}: {col}")
        
        # 显示CSV文件的列名
        print("\nCSV文件的列名:")
        for i, col in enumerate(df_csv.columns):
            print(f"{i}: {col}")
        
        # 确保CSV文件中有足够的列来存储数据
        # 根据需求，我们需要映射：序号->ID, 商品标题->描述, 商品ID->SKU, 图片地址->图片, 商品价格->常规售价
        # 检查CSV文件是否有这些列或足够的列
        required_mapping = {
            "序号": "ID",
            "商品标题": "描述",
            "商品ID": "SKU",
            "图片地址": "图片",
            "商品价格": "常规售价"
        }
        
        # 创建新的数据框来存储要追加的数据
        new_data = []
        
        # 遍历Excel中的每一行数据
        for _, row in df_excel.iterrows():
            # 创建新的行数据
            new_row = df_csv.iloc[0].copy()  # 复制第一行数据
            
            # 按照映射关系修改数据
            try:
                if "序号" in df_excel.columns and "ID" in new_row.index:
                    new_row["ID"] = row["序号"]
                
                if "商品标题" in df_excel.columns and "描述" in new_row.index:
                    new_row["描述"] = row["商品标题"]
                
                if "商品ID" in df_excel.columns and "SKU" in new_row.index:
                    new_row["SKU"] = row["商品ID"]
                
                if "图片地址" in df_excel.columns and "图片" in new_row.index:
                    new_row["图片"] = row["图片地址"]
                
                if "商品价格" in df_excel.columns and "常规售价" in new_row.index:
                    new_row["常规售价"] = row["商品价格"]
                
                new_data.append(new_row)
            except Exception as e:
                print(f"处理行数据时出错: {e}")
                continue
        
        # 如果有新数据，追加到CSV文件
        if new_data:
            # 创建新的数据框
            df_new = pd.DataFrame(new_data)
            
            # 将新数据追加到原CSV文件
            df_combined = pd.concat([df_csv, df_new], ignore_index=True)
            
            # 保存结果到CSV文件
            df_combined.to_csv(csv_file_path, index=False, encoding='utf-8-sig')
            
            print(f"成功: 已将 {len(new_data)} 条数据追加到CSV文件 '{csv_file_path}'")
            return True
        else:
            print("警告: 没有找到可追加的数据")
            return False
            
    except Exception as e:
        print(f"转换过程中发生错误: {e}")
        return False

if __name__ == "__main__":
    # 检查命令行参数
    if len(sys.argv) != 3:
        print("用法: python convert_excel_to_csv.py <excel_file_path> <csv_file_path>")
        sys.exit(1)
    
    # 获取命令行参数
    excel_file = sys.argv[1]
    csv_file = sys.argv[2]
    
    # 执行转换
    success = convert_excel_to_csv(excel_file, csv_file)
    
    if not success:
        sys.exit(1)

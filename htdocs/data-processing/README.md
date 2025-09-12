# Excel到CSV数据转换工具

这个工具可以帮助你将Excel文件中的数据按照指定的映射关系追加到CSV文件中。

## 功能说明

该脚本会读取一个Excel文件和一个CSV文件，然后按照以下映射关系将Excel中的数据追加到CSV文件中：
- Excel中的"序号" -> CSV中的"ID"
- Excel中的"商品标题" -> CSV中的"描述"
- Excel中的"商品ID" -> CSV中的"SKU"
- Excel中的"图片地址" -> CSV中的"图片"
- Excel中的"商品价格" -> CSV中的"常规售价"

在追加数据之前，脚本会先复制CSV文件的第一行数据作为模板，然后根据上述映射关系修改数据内容。

## 使用方法

### 前提条件

- 已安装Python 3.6或更高版本
- 已安装pandas和openpyxl库

如果没有安装必要的库，可以使用以下命令安装：

```bash
pip install pandas openpyxl
```

### 命令行使用

```bash
python convert_excel_to_csv.py <excel_file_path> <csv_file_path>
```

其中：
- `<excel_file_path>` 是Excel文件的路径（.xlsx格式）
- `<csv_file_path>` 是CSV文件的路径

### 示例

假设你有一个名为`products.xlsx`的Excel文件和一个名为`import_template.csv`的CSV文件，你可以使用以下命令：

```bash
python convert_excel_to_csv.py products.xlsx import_template.csv
```

## 注意事项

1. 请确保Excel文件的第一行是列标签，包含"序号"、"商品标题"、"商品ID"、"图片地址"和"商品价格"这些列名。
2. 请确保CSV文件包含"ID"、"描述"、"SKU"、"图片"和"常规售价"这些列。
3. 脚本会在执行过程中显示Excel和CSV文件的列名，帮助你确认映射关系是否正确。
4. 如果遇到任何错误，脚本会显示详细的错误信息。

## 故障排除

- 如果提示文件不存在，请检查文件路径是否正确。
- 如果提示缺少库，请使用pip安装必要的库。
- 如果映射关系不正确，请检查Excel和CSV文件的列名是否符合要求。
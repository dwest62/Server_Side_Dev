<?php

const TABLE_OPTIONS = [
    "product" =>
        [
            "name" => "Product",
            "colNames" => ["Product Name", "Color", "Price", "On Hand Quantity", "Product Page"],
            "fieldNames" => ["product_name", "color", "price", "quantity", "page"],
            "query" => "Select * FROM product",
            "explanation" => 'Table displays all non-associative data from the product dbTable.'
        ],
    "manufacturer" =>
        [
            "name" => "Manufacturer",
            "colNames" => ["Manufacturer", "Manufacturer Website"],
            "fieldNames" => ["manufacturer_name", "manufacturer_page"],
            "query" => "Select * FROM manufacturer",
            "explanation" => 'Table displays all data non-associative data from the manufacturer dbTable.'
        ],
    "department" =>
        [
            "name" => "Department",
            "colNames" => ["Department", "Department Manager"],
            "fieldNames" => ["department_name", "manager"],
            "query" => "Select * FROM department",
            "explanation" => 'Table displays all data non-associative data from the department dbTable.'
        ],
    "productOnDepartmentInnerJoin" =>
        [
            "name" => "Product on Department Inner Join",
            "colNames" => ["Product Name", "Color", "Price", "On Hand Quantity", "Product Page", "Department",
                "Department Manager"],
            "fieldNames" => ["product_name", "color", "price", "quantity", "page", "department_name", "manager"],
            "query" => "Select * FROM product JOIN department d on d.department_id = product.department",
            "explanation" => 'Table displays product dbTable entries joined with corresponding department entries, excluding entries which are NULL for the product.department field.'
        ],
    "productOnDepartmentLeftOuterJoin" =>
        [
            "name" => "Product on Department Left Outer Join",
            "colNames" => ["Product Name", "Color", "Price", "On Hand Quantity", "Product Page", "Department",
                "Department Manager"],
            "fieldNames" => ["product_name", "color", "price", "quantity", "page", "department_name", "manager"],
            "query" => "Select * FROM product LEFT OUTER JOIN department d on d.department_id = product.department",
            "explanation" => 'Table displays all product dbTable entries joined with corresponding department entries, including entries which are NULL for the product.department field.'
        ],
    "manufacturerOnProductRightOuterJoin" =>
        [
            "name" => "Manufacturer on Product Right Outer Join",
            "colNames" => ["Manufacturer", "Manufacturer Website", "Product Name", "Color", "Price", "On Hand Quantity",
                "Product Page"],
            "fieldNames" => ["manufacturer_name", "manufacturer_page","product_name", "color", "price", "quantity",
                "page"],
            "query" => "
                Select * FROM manufacturer AS m
                RIGHT OUTER JOIN product p ON m.manufacturer_id = p.manufacturer
                ORDER BY m.manufacturer_name",
            "explanation" => 'Table displays all product dbTable entries joined with corresponding manufacturer entries, including entries which are NULL for the product.manufacturer field.'
        ],
    "all" =>
        [
            "name" => "All (Show all products with department and manufacturer info)",
            "colNames" => ["Product Name", "Color", "Price", "On Hand Quantity", "Product Page", "Manufacturer",
                "Manufacturer Website", "Department","Department Manager"],
            "fieldNames" => ["product_name", "color", "price", "quantity", "page", "manufacturer_name",
                "manufacturer_page", "department_name", "manager"],
            "query" => "
                Select * FROM product AS p
                LEFT OUTER JOIN manufacturer m ON p.manufacturer = m.manufacturer_id
                LEFT OUTER JOIN department d ON p.department = d.department_id
                ORDER BY p.product_name
                ",
            "explanation" => 'Table displays all product dbTable entries joined with corresponding department entries and manufacturer entries, including entries which are NULL for the product.manufacturer fields and including entries which are NULL for the product.department fields.'
        ]
];

?>

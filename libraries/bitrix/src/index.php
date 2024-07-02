<?php
require_once(__DIR__ . '/crest.php');

//$result = CRest::call('crm.deal.fields');
//
//echo '<pre>';
//	print_r($result);
//echo '</pre>';
//die;

//$result = CRest::call('crm.contact.list',
//    [
//
//        "filter" => [
//            "PHONE" => "0981164763"
//        ],
//        "select"=> [
//            "ID",
//            "NAME",
//            "PHONE",
//            "EMAIL",
//            "ADDRESS",
//            "ADDRESS_CITY",
//            "ADDRESS_REGION",
//            "ADDRESS_PROVINCE",
//            "ADDRESS_COUNTRY",
//            "TYPE_ID",
//            "SOURCE_ID",
//        ]
//    ]
//);

//$result = CRest::call('crm.contact.get',
//    [
//
//        'id' => 6348
//    ]
//);

//$result = CRest::call('crm.dealcategory.list'
//);

//$result = CRest::call('crm.deal.list',
//    [
//        "filter" => [
//          "CONTACT_ID" => 6348
//        ],
//        "select"=> [
//            "STAGE_ID",
//            "TITLE",
//            "CATEGORY_ID",
//            "CURRENCY_ID",
//            "OPPORTUNITY",
//            "CONTACT_ID",
//        ]
//    ]
//);

//$result = CRest::call('crm.deal.add',
//    [
//        "fields"=> [
//            "TITLE" => "Iphone 13 pro max 128G - vàng",
//            "CATEGORY_ID" => 4,
//            "CURRENCY_ID" => "VND",
//            "OPPORTUNITY"=> 5000,
//            "CONTACT_ID"=> 6348,
//                "COMMENTS" => ""
//        ]
//    ]
//);

//$result = CRest::call('crm.deal.userfield.list',
//    [
//        'sort' => [
//            "SORT"=> "ASC"
//        ],
//    ]
//);

$result = CRest::call('crm.deal.fields'
);

echo '<pre>';
print_r($result);
echo '</pre>';
die;

echo '<PRE>';
print_r(CRest::call(
    'crm.contact.add',
    [
        'fields' => [
            "NAME" => "Hiếu Đồng",
            "OPENED" => "1",
            "ASSIGNED_BY_ID" => "1",
            "STAGE_ID" => "NEW",
            "TYPE_ID" => "CLIENT",
            "SOURCE_ID" => "SELF",
            "PHONE" => [
                [
                    "VALUE" => "0981164763",
                    "VALUE_TYPE" => "WORK"
                ]
            ],
            "EMAIL" => [
                [
                    "VALUE" => "hieudv@finalstyle.com",
                    "VALUE_TYPE" => "WORK"
                ]
            ],
            "ADDRESS" => "Hà Nội",
            "ADDRESS_CITY" => "Hà Nội",
            "ADDRESS_COUNTRY" => "Việt Nam",
            "ADDRESS_PROVINCE" => "Hà Nội",
            "ADDRESS_REGION" => "Thanh Trì"
        ]
    ])
);

echo '</PRE>';
die;
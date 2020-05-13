<?php
require_once 'ClassAmoCRM.php';
$amo = new amoCRM();
$amo->set_subdomain('8hr2hohtpu76');
$amo->set_client_id('ce2dd30a-c3d9-4960-bd57-c5753cbfe751');
$amo->set_client_secret('qangyb4joosHYawJD1QkcNeBwn8krhD9qwYMxwXsscvVrGT8F5kDuNm3WzUvE5lL');
$amo->set_grant_type('authorization_code');
$amo->set_code('def502000703c9a90d686a44bc8bd591aabe00d1ee478974812479bc0b022d2a49a3e792bb5fc2a5c6bb473222c9d7e89f25bf50609782aca402e716d077cfcd3b186aa06c0de097624e6f4e1e3bddc591729f853bec7449422991c1eafaf57e174d354b6969e25eb7a7d7b3c333d5aeb96c5d93a84dd923eef7b38c6b199250a493a3771591ffc3393202a4240935fea4db7b346a7a6ca87b73b58f0906f9ec7379f866f85c98795b25338810be1c14248366d774ecfeadc4e882612622565fecb0f6bbae2bc8d7cfaaae0b16dc0b68969ae2037e0e1157e3eb9b8a7fac143cf2d9ce7cedd72730a0726e36c6f77b5929e4ab0a7c4362a31c3f8877ae4e8ed0a204bf0c84b3251e6e0afa1032d8325ceb02ad949f03eda80261c349058657d2e0e01d726f3b02b5845d1c844b39f1e2af9fb7bf8c69d8a344aaaf3437885fbfbbe4192c7eef4af3f6d01ed76f824947df9344663f72e47a7c69e85526d329c8a0785b661650661dfb3b0b8df885bf75307cd4f69756473f25d4c1caaf197fd121c479f0c644154b5ad049738e0472420b87adf9307626f6c357d9ca35330c78f6a5196e247d13154b802df84613e7cbe9bd20ac44b71be023c18dcbf8c1ed8adb0258530df0867918a97a818eb9');
$amo->set_redirect_uri('http://u9991267.beget.tech/amoCRM/');
if ($amo->get_tokens()) {
    $deals = $amo->get_deals('filter/tasks=1');
    if (is_array($deals)) {
        foreach ($deals as $key => $value) {
            if (!$amo->add_task($value['id'],2,'Сделка без задачи')) {
                print_r($amo->get_error());
                }
            }
        }
        else {
            print_r($amo->get_error());
            }
    }
    else {
        print_r($amo->get_error());
        }
?>

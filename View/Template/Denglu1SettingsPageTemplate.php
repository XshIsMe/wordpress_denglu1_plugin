<form action=options.php method=post>
    <?php
    // 设置组ID
    settings_fields(Denglu1Config::SETTINGS_GROUP_ID);
    // 设置页面ID
    do_settings_sections(Denglu1Config::SETTINGS_PAGE_ID);
    // 输出保存按钮
    submit_button('保存');
    ?>
</form>
<?php
// 输出日志
Denglu1LogPage::show();
?>
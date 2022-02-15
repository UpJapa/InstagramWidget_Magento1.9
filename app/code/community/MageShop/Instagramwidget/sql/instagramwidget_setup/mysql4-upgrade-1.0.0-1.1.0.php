<?php 

$installer = $this;
$installer->startSetup();
$installer->run("
    ALTER TABLE {$this->getTable('instagramwidget/instagramwidget')}
    ADD timestamp varchar(225) DEFAULT NULL;");
$installer->endSetup();

<?php 

$installer = $this;
$installer->startSetup();
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('instagramwidget/instagramwidget')};
    CREATE TABLE {$this->getTable('instagramwidget/instagramwidget')}(
        `id` varchar(225) NOT NULL DEFAULT '',
        `alt` varchar(225) DEFAULT NULL,
        `file` varchar(225) DEFAULT NULL,
        `permalink` varchar(225) DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
$installer->endSetup();

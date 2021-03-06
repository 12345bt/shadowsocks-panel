<?php

use Phinx\Migration\AbstractMigration;

class InviteMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $sql = <<<EOF
DROP TABLE IF EXISTS `invite`;
CREATE TABLE `invite` (
  `uid` int(11) NOT NULL DEFAULT '-1' COMMENT '邀请码所属用户uid， -1为公共邀请码',
  `dateLine` int(11) DEFAULT NULL COMMENT '添加时间',
  `expiration` int(3) DEFAULT '10' COMMENT '有效期',
  `inviteIp` varchar(32) DEFAULT NULL,
  `invite` varchar(128) NOT NULL,
  `reguid` int(11) DEFAULT NULL COMMENT '邀请码被哪个用户注册',
  `regDateLine` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `plan` varchar(10) DEFAULT 'A',
  `status` tinyint(1) DEFAULT '0' COMMENT '-1过期 0-未使用 1-已用',
  PRIMARY KEY (`invite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `invite` (`uid`, `dateLine`, `expiration`, `inviteIp`, `invite`, `reguid`, `regDateLine`, `plan`, `status`) VALUES ('-1', '1454638687', '999', '127.0.0.1', '334ab1a9fbc19b4c688ca7fd5f8f9ffa', NULL, '0', 'VIP', '0');
EOF;

        $this->execute($sql);
    }

    public function up()
    {

    }
}

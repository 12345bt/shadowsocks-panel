<?php
/**
 * SS-Panel
 * A simple Shadowsocks management system
 * Author: Sendya <18x@loacg.com>
 */
namespace Model;

use Core\Database;

class Message {
    public $id;
    public $content; //内容
    public $pushTime =0; //推送时间
    public $addTime =0; //添加时间
    public $pushUsers; //推送用户 为空或-1值推送给所有用户 指定用户，使用json格式,例子{1,3,4,5,6,7,10,11}
    public $type = 0; //消息类型： 0 正常消息(推送一次后将不会再次提示) 1 重复推送消息
    public $pushEndTime =0; //结束推送时间
    public $order = 0;

    /**
     * Get message by Id
     * @param $msgId
     * @return message
     */
    public static function GetMessageById($msgId) {
        $statement = Database::prepare("SELECT * FROM message WHERE id=?");
        $statement->bindValue(1, $msgId);
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS, '\\Model\\Message');
        return $statement->fetch(\PDO::FETCH_CLASS);
    }

    /**
     * Get push message array
     * @param $pushEndTime
     * @return message[]
     */
    public static function GetPushMsg($pushEndTime = 0) {
        if ($pushEndTime == 0)
            $pushEndTime = time();

        $statement = Database::prepare("SELECT * FROM message WHERE pushEndTime>?");
        $statement->bindValue(1, $pushEndTime);
        $statement->execute();
        $list = $statement->fetchAll(\PDO::FETCH_CLASS, '\\Model\\Message');
        return $list;
    }

    /**
     * Get push message by userId
     * @param $userId
     * @return message list
     */
    public static function GetPushMsgByUserId($userId = "-1") {
        $statement = Database::prepare("SELECT * FROM message WHERE LOCATE(?, pushUsers)>0 AND pushEndTime>? ORDER BY id ASC");
        $statement->bindValue(1, $userId, \PDO::PARAM_STR);
        $statement->bindValue(2, time(), \PDO::PARAM_INT);
        $statement->execute();
        $list = $statement->fetchAll(\PDO::FETCH_CLASS, '\\Model\\Message');
        return $list;
    }

    /**
     * Get global message
     * @return message list
     */
    public static function GetGlobalMessage() {
        $statement = Database::prepare("SELECT * FROM message WHERE pushUsers=-2 AND type BETWEEN -5 AND -2 ORDER BY id ASC");
        $statement->execute();
        $list = $statement->fetchAll(\PDO::FETCH_CLASS, '\\Model\\Message');
        return $list;
    }
    /**
     * Delete push time out message
     */
    public static function deleteOutTimeMsg() {
        $inTransaction = Database::inTransaction();
        if (!$inTransaction) Database::beginTransaction();
        $statement = Database::prepare("DELETE * FROM message WHERE pushEndTime< :pushEndTime");
        $statement->bindValue(":pushEndTime", time(), \PDO::PARAM_INT);
        $statement->execute();
        if (!$inTransaction) Database::commit();
    }

    /**
     * delete message by id
     * @param $msgId
     * @return bool
     */
    public static function deleteMsgById($msgId) {
        $inTransaction = Database::inTransaction();
        if (!$inTransaction) Database::beginTransaction();
        $statement = Database::prepare("DELETE * FROM message WHERE id=:id");
        $statement->bindValue(":id", $msgId, \PDO::PARAM_INT);
        $rs = $statement->execute();
        if (!$inTransaction) Database::commit();
        return $rs;
    }

    /**
     * Add message
     * @return string
     */
    public function insertToDB() {
        $statement = null;

        $inTransaction = Database::inTransaction();
        if (!$inTransaction) Database::beginTransaction();
        $statement = Database::prepare("INSERT INTO message SET `content`=:content, `pushTime`=:pushTime,
			`addTime`=:addTime, `pushUsers`=:pushUsers, `type`=:type, `pushEndTime`=:pushEndTime, `order`=:order");
        $statement->bindValue(':content', $this->content, \PDO::PARAM_STR);
        $statement->bindValue(':pushTime', $this->pushTime, \PDO::PARAM_INT);
        $statement->bindValue(':addTime', $this->addTime, \PDO::PARAM_INT);
        $statement->bindValue(':pushUsers', $this->pushUsers, \PDO::PARAM_STR);
        $statement->bindValue(':type', $this->type, \PDO::PARAM_INT);
        $statement->bindValue(':pushEndTime', $this->pushEndTime, \PDO::PARAM_INT);
        $statement->bindValue(':order', $this->order, \PDO::PARAM_INT);
        $statement->execute();
        $this->id = Database::lastInsertId();
        if (!$inTransaction) Database::commit();

        return $this->id;
    }

    /**
     * Update message
     */
    public function update() {
        $inTransaction = Database::inTransaction();
        if (!$inTransaction) Database::beginTransaction();
        $statement = Database::prepare("UPDATE message SET `content`=:content, `pushTime`=:pushTime,
			`addTime`=:addTime, `pushUsers`=:pushUsers, `type`=:type, `pushEndTime`=:pushEndTime,
			 `order`=:order WHERE id=:id");
        $statement->bindValue(':content', $this->content, \PDO::PARAM_STR);
        $statement->bindValue(':pushTime', $this->pushTime, \PDO::PARAM_INT);
        $statement->bindValue(':addTime', $this->addTime, \PDO::PARAM_INT);
        $statement->bindValue(':pushUsers', $this->pushUsers, \PDO::PARAM_STR);
        $statement->bindValue(':type', $this->type, \PDO::PARAM_INT);
        $statement->bindValue(':pushEndTime', $this->pushEndTime, \PDO::PARAM_INT);
        $statement->bindValue(':order', $this->order, \PDO::PARAM_INT);
        $statement->bindValue(':id', $this->id, \PDO::PARAM_INT);
        $statement->execute();
        if (!$inTransaction) Database::commit();
    }

}
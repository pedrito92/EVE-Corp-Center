<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 19/05/15
 * Time: 22:37
 */

namespace kernel\classes\mail;


class ECCMail {
    protected $to;
    protected $from;
    protected $subject;
    protected $msg;
    protected $cci;
    protected $cc;
    public $data;
    private $emailGenerated = false;

    function __construct($to, $subject){
        $this->to = $to;
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param mixed $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return mixed
     */
    public function getCci()
    {
        return $this->cci;
    }

    /**
     * @param mixed $cci
     */
    public function setCci($cci)
    {
        $this->cci = $cci;
    }

    /**
     * @return mixed
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @param mixed $cc
     */
    public function setCc($cc)
    {
        $this->cc = $cc;
    }


    function generateEmail(){

        return $this->emailGenerated;
    }

    function send(){

        if($this->emailGenerated){
            return true;
        }

        return 'Email non généré avant envoi.';
    }

}
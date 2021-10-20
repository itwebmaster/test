<?php


class VisitorHelper
{


    public static function updateOrCreate(){
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $visitor_info = [
            ':ip_address' => self::getVisitorIP(),
            ':user_agent' => $_SERVER['HTTP_USER_AGENT'],
            ':page_url' => $actual_link,
        ];


        $visitor = self::getVisitor($visitor_info);

        if(!$visitor){
            self::create($visitor_info);
        }else{
            self::incrementViewsCount($visitor);
        }

    }

    public static function create($visitor_info){
        $sth = App::site()->db->prepare('INSERT INTO visitors (ip_address, user_agent, page_url) VALUES (:ip_address, :user_agent, :page_url)');
        $sth->execute($visitor_info);
    }

    public static function getVisitor($visitor_info){
        $sql = 'SELECT id FROM `visitors` WHERE ip_address = :ip_address AND user_agent = :user_agent AND page_url = :page_url';
        $prepared = App::site()->db->prepare($sql);
        $prepared->execute($visitor_info);
        if($prepared->rowCount()){
            return $prepared->fetch();
        }else{
            return null;
        }
    }

    public static function incrementViewsCount($visitor){
        $sth = App::site()->db->prepare('UPDATE visitors SET views_count = views_count + 1 WHERE id = :id');
        $sth->execute([':id' => $visitor['id']]);
    }


    public static function getVisitorIP(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }



}
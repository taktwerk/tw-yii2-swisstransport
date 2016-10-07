<?php
namespace taktwerk\swisstransport\components;

use Yii;

class Connection
{

    private $bus;
    private $apiUrl;
    private $limit;

    public function __construct()
    {
        $this->bus = \Yii::$app->getModule('swisstransport')->busLines;
        $this->apiUrl = \Yii::$app->getModule('swisstransport')->apiUrl;
        $this->limit = \Yii::$app->getModule('swisstransport')->limit;
    }

    public function getNext()
    {
        $result = [];
        if (empty($this->bus))
            return false;
        foreach ($this->bus as $title => $bus) {
            $departure = [];
            if (!empty($bus)) {
                if (!is_array($bus['to']))
                    $bus['to'] = array($bus['to']);

                foreach ($bus['to'] as $to) {
                    $response = $this->call(urlencode($bus['from']), urlencode($to));
                    $time = [];
                    foreach ($response->connections as $connection) {
                        $time[] = date('H:i', $connection->from->departureTimestamp);
                    }
                    $departure[$to] = implode(', ' , $time);
                }
                $result[$title] = [
                    'from' => $bus['from'],
                    'to' => $departure,
                ];
            }

        }
        return $result;
    }

    private function call($from, $to)
    {
        $curl = curl_init();
        $url = $this->apiUrl . '?from=' . $from . '&to=' . $to . '&direct=1&limit=' . $this->limit . '&date=' . date('Y-m-d', time());
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $result = curl_exec($curl);
        $ch_error = curl_error($curl);
        curl_close($curl);
        return json_decode($result);
    }
}
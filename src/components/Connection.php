<?php
namespace taktwerk\swisstransport\components;

use yii\base\Component;
use taktwerk\swisstransport\Module;
use taktwerk\swisstransport\exception\Exception;
use taktwerk\swisstransport\exception\ApiException;

class Connection extends Component
{

    /**
     * @var array Bus lines
     */
    private $bus;

    /**
     * @var string The API to call.
     * Doc: http://transport.opendata.ch/docs.html
     */

    private $apiUrl;
    /**
     * How much next departures to show
     * @var int
     */
    private $limit;

    /**
     * Time in seconds until cache is refreshed
     * @var int
     */
    private $cacheTime = 60;

    /**
     * @var \taktwerk\swisstransport\Module
     */
    protected $module;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->module = Module::getInstance();
        if (empty($this->module->busLines)) {
            throw new Exception(\Yii::t('app', 'No Buslines in configuration'));
        }
        $this->bus = $this->module->busLines;
        if (empty($this->module->apiUrl)) {
            throw new Exception(\Yii::t('app', 'No API Url in configuration'));
        }
        $this->apiUrl = $this->module->apiUrl;

        $this->limit = $this->module->limit;
        $this->cacheTime = $this->module->cacheTime;
    }

    /**
     * Return next departure times as array
     * @return array|bool
     * @throws Exception
     */
    public function getNext()
    {
        $result = [];
        if (empty($this->bus)) {
            throw new Exception (\Yii::t('app', '"busLines" parameter can not be empty'));
        }
        if (!is_array($this->bus)) {
            throw new Exception (\Yii::t('app', '"busLines" parameter need to be array'));
        }
        foreach ($this->bus as $title => $bus) {
            $departure = [];
            if (!empty($bus)) {
                if (is_array($bus['from'])) {
                    throw new Exception (\Yii::t('app', '"from" key can not be array'));
                }
                if (!is_array($bus['to'])) {
                    // if to key is string convert it to array
                    $bus['to'] = array($bus['to']);
                }
                foreach ($bus['to'] as $to) {
                    $response = $this->call(urlencode($bus['from']), urlencode($to));
                    $time = [];
                    foreach ($response->connections as $connection) {
                        $time[] = \Yii::$app->getFormatter()->asTime($connection->from->departureTimestamp, 'short');
                    }
                    $departure[$to] = implode(', ', $time);
                }
                $result[$title] = [
                    'from' => $bus['from'],
                    'to' => $departure,
                ];
            }

        }
        return $result;
    }

    /**
     * Make API request
     * @param $from
     * @param $to
     * @return mixed
     * @throws ApiException
     */
    private function call($from, $to)
    {
        $curl = curl_init();
        $url = $this->apiUrl . '?from=' . $from . '&to=' . $to . '&direct=1&limit=' . $this->limit . '&date=' . date('Y-m-d', time());
        $key = md5($url);
        // Try to get from cache first
        $result = \Yii::$app->getCache()->get($key);
        if ($result === false) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            $result = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpcode != 302 && $httpcode != 200) {
                throw new ApiException (\Yii::t('app', 'No response from API'));
            }
            curl_close($curl);
            $result = json_decode($result);
            // Save to cache
            \Yii::$app->getCache()->set($key, $result, $this->cacheTime);
        }
        return $result;
    }
}
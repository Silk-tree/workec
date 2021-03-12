<?php
/**
 * EC开放平台API.
 *
 * @author oiuv <i@oiuv.cn>
 *
 * @version 2.0.2
 *
 * @link https://open.workec.com/newdoc/
 */

namespace RossEdu\WorkEc;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EC
{

    /**
     * 公司ID.
     *
     * @var int
     */
    private $corpId;

    /**
     * EC APP ID.
     *
     * @var float
     */
    private $appId;

    /**
     * app_secret.
     *
     * @var string
     */
    private $appSecret;

    /**
     * HTTP 客户端.
     */
    private $client;

    private $baseUrlV2 = 'https://open.workec.com/v2/';

    public function __construct($corpId = '', $appId = '', $appSecret = '')
    {
        $this->client = new Client(['base_uri' => $this->baseUrlV2]);

        $this->corpId = trim($corpId);
        $this->appId = trim($appId);
        $this->appSecret = trim($appSecret);
    }

    public function client($method, $uri, $data = [])
    {
        // 获取当前时间戳
        $timeStamp = time() * 1000;
        // 获取签名
        $sign = $this->getSign($timeStamp, $this->appId, $this->appSecret);

        try {
            $response = $this->client->request($method, $uri, [
                'headers' => [
                    'Content-Type'   => 'application/json; charset=utf-8',
                    'X-Ec-Cid'       => $this->corpId,
                    'X-Ec-Sign'      => $sign,
                    'X-Ec-TimeStamp' => $timeStamp,
                ],
                'json'    => $data,
            ]);

            return $response->getBody()->getContents();
        } catch (GuzzleException $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * 签名算法.
     *
     * @param int    $timeStamp
     * @param string $appId
     * @param string $appSecret
     *
     * @return string 返回签名数据
     */
    public function getSign($timeStamp, $appId, $appSecret)
    {
        $sign = "appId={$appId}&appSecret={$appSecret}&timeStamp={$timeStamp}";

        return strtoupper(md5($sign));
    }

    /**********客户相关接口**********/

    /**
     * 修改客户标签(支持批量).
     */
    public function updateLabel($data)
    {

        $uri = 'label/update';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 查询客户标签(支持批量).
     *
     * @param string $crmIds 客户id列表，多个id使用英文逗号分隔
     */
    public function queryLabel($data)
    {
        $uri = 'customer/queryLabel';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 放弃客户(支持批量).
     */
    public function abandonCustomer($data)
    {

        $uri = 'customer/change/abandon';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 变更跟进人(支持批量).
     */
    public function customerChangeUser($data)
    {

        $uri = 'customer/change/user';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 查询客户分组(请求协议错误！???).
     */
    public function getCustomerGroup($data)
    {
        $uri = 'customer/getCustomerGroup';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 查询客户轨迹.
     */
    public function getTrajectory($data)
    {
        $uri = 'customer/getTrajectory';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 分页查询客户信息.
     */
    public function customerQuery($data)
    {
        $uri = 'customer/query';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 自定义分页查询客户信息.
     */
    public function getCustomer($data)
    {

        $uri = 'customer/query';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 批量查询客户信息.
     */
    public function preciseQuery($data)
    {

        $uri = 'customer/preciseQuery';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 创建客户.
     */
    public function addCustomer($data)
    {

        $uri = 'customer/addCustomer';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 批量创建客户.
     */
    public function addCustomers($data)
    {

        $uri = 'customer/addCustomer';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 合并客户.
     */
    public function combineCustomer($data)
    {
        $uri = 'customer/combine';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 修改客户信息.
     */
    public function updateCustomer($data)
    {
        $uri = 'customer/updateCustomer';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 批量修改客户信息.
     */
    public function batchUpdateCustomer(array $data)
    {

        $uri = 'customer/batchUpdateCustomer';
        $method = 'POST';

        return $this->client($method, $uri, $data);

    }

    /**
     * 修改客户阶段(支持批量).
     */
    public function updateStep($data)
    {

        $uri = 'step/update';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**********异步任务相关接口**********/

    /**
     * 创建任务.
     */
    public function createTask($data)
    {

        $uri = 'asynchronization/create';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 查询任务.
     */
    public function queryTask($data)
    {

        $uri = 'asynchronization/query';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**********机器人相关接口**********/

    /**
     * 增加任务.
     */
    public function addTask($data)
    {

        $uri = 'robot/addtask';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 增加任务记录.
     */
    public function addTaskRecord($data)
    {
        $uri = 'robot/addtaskrecord';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 更新任务.
     */
    public function updateTask($data)
    {

        $uri = 'robot/updatetask';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**********组织架构相关接口**********/

    /**
     * 创建部门.
     */
    public function createDept($data)
    {
        $uri = 'org/dept/create';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 编辑部门.
     */
    public function editDept($data)
    {
        $uri = 'org/dept/edit';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 获取架构信息.
     */
    public function structure()
    {

        $uri = 'org/struct/info';
        $method = 'get';

        return $this->client($method, $uri);


    }

    /**
     * 创建员工.
     */
    public function createUser($data)
    {

        $uri = 'org/user/create';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    public function updateUser($data)
    {

        $uri = 'org/user/updateUser';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    public function findUserInfoById($data)
    {

        $uri = 'org/user/findUserInfoById';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 启用/禁用员工.
     */
    public function User($data)
    {
        $uri = 'org/user/onoff';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**********记录相关接口**********/

    /**
     * 电话外呼.
     */
    public function call($data)
    {
        $uri = 'record/call';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 电话空闲用户.
     */
    public function getFreeStatusUid($data)
    {

        $uri = 'record/getFreeStatusUid';
        $method = 'POST';

        return $this->client($method, $uri, $data);

    }

    /**
     * 短信记录.
     */
    public function smsRecord($data)
    {
        $uri = 'record/smsRecord';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 电话记录.
     */
    public function telRecord($data)
    {
        $uri = 'record/telRecord';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**********配置相关接口**********/

    /**
     * 获取自定义字段.
     */
    public function getFieldMapping()
    {

        $uri = 'config/getFieldMapping';
        $method = 'GET';

        return $this->client($method, $uri);
    }

    /**
     * 获取标签信息.
     */
    public function getLabelInfo()
    {
        $response = $this->client('get', 'config/getLabelInfo');

        return $response;
    }

    /**
     * 获取业务组信息.
     */
    public function getPubicPond()
    {
        $response = $this->client('get', 'config/getPubicPond');

        return $response;
    }

    /**********统计相关接口**********/

    /**
     * 电话-数字图接口.
     */
    public function phoneDigitalMap($data)
    {
        $uri = 'statistics/digitalMap/phone';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 电话-折线图接口.
     */
    public function phoneLineGraph($data)
    {
        $uri = 'statistics/lineGraph/phone';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 工作效率-数字图接口.
     */
    public function workefficDigitalMap($data)
    {
        $uri = 'statistics/digitalMap/workeffic';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 工作效率-柱状图接口.
     */
    public function workfficHistogram($data)
    {
        $uri = 'statistics/histogram/workeffic';
        $method = 'POST';

        return $this->client($method, $uri, $data);

    }

    /**
     * 标签-数字图接口.
     */
    public function tagDigitalMap($data)
    {

        $uri = 'statistics/digitalMap/tag';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 标签-柱状图接口.
     */
    public function tagHistogram($data)
    {
        $uri = 'statistics/histogram/tag';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    /**
     * 客户数量-数字图接口.
     */
    public function crmDigitalMap($data)
    {
        $uri = 'statistics/digitalMap/crmQuantity';
        $method = 'POST';

        return $this->client($method, $uri, $data);
    }

    public function getChannelSource()
    {
        $uri = 'customer/getChannelSource';
        $method = 'GET';

        return $this->client($method, $uri);
    }
}

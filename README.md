<h1 align="center">EC开放平台</h1>

<p align="center">使用API，您可将EC与第三方系统进行数据级别的集成</p>

## 环境需求

- PHP >= 7.1

## 安装

```shell

$ composer require "rossedu/workec"

```

## 使用
### note
所有接口传参请参照官方文档,所有参数和官方一样,传递方式也一样

```php
use RossEdu\WorkEc\EC;

$ec = new EC('corpId', 'appId', 'appSecret');
```

> 获取部门和员工信息

```php
echo $ec->structure();
```

> 查询客户

```php
//分页查询客户信息
  $data = [
            "followUserId" => 0,
            "modifyTime"   => ["endTime" => "2020-08-25 10:00:00", "startTime" => "2020-08-25 00:00:00"],
            "pageInfo"     => ["pageNo" => 1, "pageSize" => 1],
            "step"         => 0,
        ];
echo $ec->queryCustomer($data);

//批量查询客户信息

$data = ["crmIds" => "3490075867,3490075867"];
echo $ec->preciseQuery($data);
```

> 创建客户

```php
$data = [
            "list"      => [
                ["followUserId" => 7689179, "mobile" => "13510472121", "name" => "shicy-test-002"],
                ["followUserId" => 7689179, "mobile" => "13510472121", "name" => "shicy-test-003"],
            ],
            "optUserId" => 7689179,
        ];
echo $ec->addCustomer($data);

```


### 方法列表

| 方法 | 说明 |
| ---- | ---- |
| updateLabel | 修改客户标签(支持批量) |
| queryLabel | 查询客户标签(支持批量) |
| abandonCustomer | 放弃客户(支持批量) |
| customerChangeUser | 变更跟进人(支持批量) |
| getCustomerGroup | 查询客户分组(请求协议错误！???) |
| getTrajectory | 查询客户轨迹 |
| queryCustomer | 分页查询客户信息 |
| getCustomer | 自定义分页查询客户信息 |
| preciseQueryCustomer | 批量查询客户信息 |
| addCustomer | 创建客户 |
| addCustomers | 批量创建客户 |
| combineCustomer | 合并客户 |
| updateCustomer | 修改客户信息 |
| batchUpdateCustomer | 批量修改客户信息 |
| updateStep | 修改客户阶段(支持批量) |
| createDept | 创建部门 |
| editDept | 编辑部门 |
| structure | 获取架构信息 |
| createUser | 创建员工 |
| User | 启用/禁用员工 |
| call | 电话外呼 |
| smsRecord | 短信记录 |
| telRecord | 电话记录 |
| getLabelInfo | 获取标签信息 |

> 更多方法看源码并参考EC开放平台技术文档

- [EC开放平台技术文档](https://open.workec.com/newdoc/)

## License

MIT

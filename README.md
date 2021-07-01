# Weather

基于 [高德开放平台](https://lbs.amap.com/dev/id/newuser) 的 PHP 天气信息组件。

## 安装

```sh
$ composer require duoyin/weather -vvv
```

## 配置

在使用本扩展之前，你需要去 [高德开放平台](https://lbs.amap.com/dev/id/newuser) 注册账号，然后创建应用，获取应用的 API Key。

## 使用

```php
use Duoyin\Weather\Weather;

$key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

$weather = new Weather($key);
```

### 获取实时天气

```php
$response = $weather->getWeather('深圳');
```

示例：

```php
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "lives": [
        {
            "province": "广东",
            "city": "深圳市",
            "adcode": "440300",
            "weather": "阴",
            "temperature": "29",
            "winddirection": "南",
            "windpower": "4",
            "humidity": "77",
            "reporttime": "2021-07-01 20:30:08"
        }
    ]
}
```

### 获取近期天气预报

```php
$response = $weather->getWeather('深圳', 'all');
```

示例：

```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "forecasts": [
        {
            "city": "深圳市",
            "adcode": "440300",
            "province": "广东",
            "reporttime": "2021-07-01 20:30:08",
            "casts": [
                {
                    "date": "2021-07-01",
                    "week": "4",
                    "dayweather": "多云",
                    "nightweather": "多云",
                    "daytemp": "33",
                    "nighttemp": "27",
                    "daywind": "南",
                    "nightwind": "南",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2021-07-02",
                    "week": "5",
                    "dayweather": "多云",
                    "nightweather": "多云",
                    "daytemp": "32",
                    "nighttemp": "27",
                    "daywind": "西南",
                    "nightwind": "西南",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2021-07-03",
                    "week": "6",
                    "dayweather": "多云",
                    "nightweather": "多云",
                    "daytemp": "33",
                    "nighttemp": "27",
                    "daywind": "北",
                    "nightwind": "北",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2021-07-04",
                    "week": "7",
                    "dayweather": "晴",
                    "nightweather": "多云",
                    "daytemp": "33",
                    "nighttemp": "28",
                    "daywind": "北",
                    "nightwind": "北",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                }
            ]
        }
    ]
}
```

### 获取 XML 格式返回值

第三个参数为返回值类型，可选 `json` 与 `xml`，默认 `json`：

```php
$response = $weather->getWeather('深圳', 'all', 'xml');
```

示例：

```xml
<?xml version="1.0" encoding="UTF-8"?>
<response>
<status>1</status>
<count>1</count>
<info>OK</info>
<infocode>10000</infocode>
<lives type="list"><live>
<province>广东</province>
<city>深圳市</city>
<adcode>440300</adcode>
<weather>阴</weather>
<temperature>29</temperature>
<winddirection>南</winddirection>
<windpower>4</windpower>
<humidity>77</humidity>
<reporttime>2021-07-01 20:30:08</reporttime>
</live></lives>
</response>
```

### 参数说明

```php
array|string getWeather(string $city, string $type = 'base', string $format = 'json')
```

> - `$city` - 城市名，比如：“深圳”；
> - `$type` - 返回内容类型：`base`: 返回实况天气 / `all`: 返回预报天气；
> - `$format` - 输出的数据格式，默认为 json 格式，当 output 设置为 “`xml`” 时，输出的为 XML 格式的数据。
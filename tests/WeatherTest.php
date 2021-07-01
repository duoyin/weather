<?php
namespace Duoyin\Weather\Tests;

use GuzzleHttp\ClientInterface;
use Duoyin\Weather\Exceptions\InvalidArgumentException;
use Duoyin\Weather\Weather;
use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase
{
    protected $key = '9e50c81a25e5d9d086f9b68715e07441';

    public function testGetWeather()
    {
        $w = new Weather($this->key);
        $arr_return = $w->getWeather('深圳');
        if (!isset($arr_return['status']) || $arr_return['status'] != 1) {
            $this->fail('正常请求1 出错');
        }

        $str_return = $w->getWeather('深圳', 'all', 'xml');
        if (strstr($str_return, '深圳') === false) {
            $this->fail('正常请求2 出错');
        }
    }

    public function testGetHttpClient()
    {
        $w = new Weather($this->key);

        // 断言返回结果为 GuzzleHttp\ClientInterface 实例
        $this->assertInstanceOf(ClientInterface::class, $w->getHttpClient());
    }

    public function testSetGuzzleOptions()
    {
        $w = new Weather($this->key);

        // 设置参数前，timeout 为 null
        $this->assertNull($w->getHttpClient()->getConfig('timeout'));

        // 设置参数
        $w->setGuzzleOptions(['timeout' => 5000]);

        // 设置参数后，timeout 为 5000
        $this->assertSame(5000, $w->getHttpClient()->getConfig('timeout'));
    }

    // 检查 $type 参数
    public function testGetWeatherWithInvalidType()
    {
        $w = new Weather($this->key);
        // 断言会抛出此异常类
        $this->expectException(InvalidArgumentException::class);
        // 断言异常消息为 'Invalid type value(base/all): foo'
        $this->expectExceptionMessage('Invalid type value(base/all): foo');
        $w->getWeather('深圳', 'foo');

        $this->fail('type 参数异常 未正确断言');
    }

    // 检查 $format 参数
    public function testGetWeatherWithInvalidFormat()
    {
        $w = new Weather($this->key);

        // 断言会抛出此异常类
        $this->expectException(InvalidArgumentException::class);

        // 断言异常消息为 'Invalid response format: array'
        $this->expectExceptionMessage('Invalid response format: array');

        // 因为支持的格式为 xml/json，所以传入 array 会抛出异常
        $w->getWeather('深圳', 'base', 'array');

        // 如果没有抛出异常，就会运行到这行，标记当前测试没成功
        $this->fail('format 参数异常 未正确断言');
    }
}
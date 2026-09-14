<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Src\MyGreeter;

class MyGreeterTest extends TestCase
{
    private MyGreeter $greeter;

    public function setUp(): void
    {
        $this->greeter = new MyGreeter();
    }

    public function test_init()
    {
        $this->assertInstanceOf(
            MyGreeter::class,
            $this->greeter
        );
    }

    /**
     * 不传参数时应基于当前时间返回三种合法问候语之一
     */
    public function test_greeting()
    {
        $this->assertContains(
            $this->greeter->greeting(),
            ['Good morning', 'Good afternoon', 'Good evening']
        );
    }

    /**
     * 传入固定时间时，应返回与时间段对应的问候语
     * 覆盖三个分支及 6:00、12:00、18:00 等边界值
     */
    #[DataProvider('greetingTimeProvider')]
    public function test_greeting_returns_expected_message_by_time(string $time, string $expected)
    {
        $this->assertSame(
            $expected,
            $this->greeter->greeting(new DateTime($time))
        );
    }

    public static function greetingTimeProvider(): array
    {
        return [
            // [给定时间, 期望返回]
            '午夜 00:00 属于晚上'        => ['00:00', 'Good evening'],
            '05:59 仍是晚上'            => ['05:59', 'Good evening'],
            '06:00 起是上午（边界）'     => ['06:00', 'Good morning'],
            '11:59 仍是上午'            => ['11:59', 'Good morning'],
            '12:00 起是下午（边界）'     => ['12:00', 'Good afternoon'],
            '17:59 仍是下午'            => ['17:59', 'Good afternoon'],
            '18:00 起是晚上（边界）'     => ['18:00', 'Good evening'],
            '23:59 仍是晚上'            => ['23:59', 'Good evening'],
        ];
    }
}

<?php
namespace Src;

/**
 * 根据当前时间返回问候语
 */
class MyGreeter
{
    /**
     * 构造函数（初始化方法）
     * 使用 new MyGreeter() 实例化时自动调用；当前没有需要初始化的内容，故方法体为空
     */
    public function __construct()
    {
    }

    /**
     * 根据时间返回问候语
     *
     * @param \DateTimeInterface|null $time 可选，待判断的时间；不传时使用当前时间。
     * 允许注入时间是为了让结果可控、便于单元测试。
     */
    public function greeting(?\DateTimeInterface $time = null): string
    {
        // 未传入时间时，默认取当前时间
        $time ??= new \DateTime();

        // 获取时间中的小时数（0-23）
        $currentHour = (int) $time->format('H');

        // 根据时间判断是上午、下午还是晚上
        // 上午：6:00（含）-12:00（不含）
        if ($currentHour >= 6 && $currentHour < 12) {
            return "Good morning";
        }
        // 下午：12:00（含）-18:00（不含）
        if ($currentHour >= 12 && $currentHour < 18) {
            return "Good afternoon";
        }

        // 晚上：18:00（含）至次日 6:00（不含）
        return "Good evening";
    }
}
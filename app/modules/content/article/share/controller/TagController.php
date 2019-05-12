<?php

namespace content\article\controller;

use content\article\DataUnit;
use content\article\data\TagData;
use content\article\data\TagRelateData;
use ReflectionException;
use suda\application\database\DataAccess;
use suda\orm\exception\SQLException;

/**
 * 标签
 */
class TagController
{

    /**
     * 逻辑单元
     *
     * @var DataUnit
     */
    protected $unit;

    /**
     * 控制器
     *
     * @var DataAccess
     */
    protected $access;


    public function __construct(DataUnit $unit)
    {
        $this->access = $unit->unit(TagData::class);
        $this->unit = $unit;
    }

    /**
     * @param string $article
     * @param array $tag
     * @param bool $create
     * @throws ReflectionException
     * @throws SQLException
     */
    public function saveTag(string $article, array $tag, bool $create)
    {
        foreach ($tag as $name) {
            $tagid = $create ? $this->save($name) : $this->getId($name);
            if (strlen($tagid)) {
                $this->relate($tagid, $article);
            }
        }
    }

    /**
     * 保存标签
     *
     * @param string $name
     * @return string
     * @throws ReflectionException
     * @throws SQLException
     */
    public function save(string $name): string
    {
        if ($data = $this->access->read(['id'])->where(['name' => $name])->one()) {
            return $data['id'];
        }
        $data = new TagData;
        $data['name'] = $name;
        $data['time'] = $data['time'] ?? time();
        $data['count'] = 0;
        return $this->access->write($data)->id();
    }

    /**
     * 获取标签ID
     *
     * @param string $name
     * @return string
     * @throws SQLException
     */
    public function getId(string $name): string
    {
        $tag = $this->access->read(['id'])->where(['name' => $name])->one();
        if ($tag) {
            return $tag['id'];
        }
        return '';
    }

    /**
     * @param string $tag
     * @param string $relate
     * @return bool
     * @throws ReflectionException
     * @throws SQLException
     */
    public function relate(string $tag, string $relate): bool
    {
        $unit = $this->unit->unit(TagRelateData::class);
        if ($unit->read(['id'])->where(['tag' => $tag, 'relate' => $relate])->one()) {
            return true;
        }
        return $unit->write(['tag' => $tag, 'relate' => $relate])->ok();
    }
}
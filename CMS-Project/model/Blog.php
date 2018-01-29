<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 07/09/2017
 * Time: 11:40
 */

namespace model;


class Blog
{
    private $id;
    private $author;
    private $title;
    private $text;
    private $image;
    private $files;
    private $active;
    private $dateBeg;
    private $dateEnd;
    private $position;


    /**
     * Blog constructor.
     * @param $id
     * @param $author
     * @param $title
     * @param $text
     * @param $image
     * @param $files
     * @param $active
     * @param $dateBeg
     * @param $dateEnd
     * @param $position
     */
    public function __construct($id, $author, $title, $text, $image, $files, $active, $dateBeg, $dateEnd, $position)
    {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->text = $text;
        $this->image = $image;
        $this->files = $files;
        $this->active = $active;
        $this->dateBeg = $dateBeg;
        $this->dateEnd = $dateEnd;
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return mixed
     */
    public function getDateBeg()
    {
        return $this->dateBeg;
    }

    /**
     * @return mixed
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }


}
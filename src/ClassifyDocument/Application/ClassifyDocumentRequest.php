<?php

namespace Dojo\ClassifyDocument\Application;


use DateTime;

class ClassifyDocumentRequest
{
    /**
     * @var string
     */
    private $studentId;
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $path;
    /**
     * @var DateTime
     */
    private $dateTime;
    /**
     * @var string
     */
    private $type;

    public function __construct(
        string $studentId,
        string $subject,
        string $type,
        string $path,
        DateTime $dateTime
    )
    {
        $this->studentId = $studentId;
        $this->subject = $subject;
        $this->type = $type;
        $this->path = $path;
        $this->dateTime = $dateTime;
    }

    /**
     * @return string
     */
    public function studentId() : string
    {
        return $this->studentId;
    }

    /**
     * @return string
     */
    public function subject() : string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function type() : string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function path() : string
    {
        return $this->path;
    }

    /**
     * @return DateTime
     */
    public function dateTime() : DateTime
    {
        return $this->dateTime;
    }
}

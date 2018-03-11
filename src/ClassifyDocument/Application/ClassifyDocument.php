<?php

namespace Dojo\ClassifyDocument\Application;


use Dojo\ClassifyDocument\Domain\StudentRepository;

class ClassifyDocument
{
    /**
     * @var SchoolYearCalculator
     */
    private $schoolYearCalculator;
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * ClassifyDocument constructor.
     *
     * @param SchoolYearCalculator $schoolYearCalculator
     * @param StudentRepository    $studentRepository
     */
    public function __construct(
        SchoolYearCalculator $schoolYearCalculator,
        StudentRepository $studentRepository
    ) {
        $this->schoolYearCalculator = $schoolYearCalculator;
        $this->studentRepository = $studentRepository;
    }

    public function execute(ClassifyDocumentRequest $classifyDocumentRequest) : string
    {
        $date = $classifyDocumentRequest->dateTime();
        $schoolYear = $this->schoolYearCalculator->forDate($date);

        $student = $this->studentRepository->byId(
            $classifyDocumentRequest->studentId()
        );

        $fileName = $this->computeNewFileName($classifyDocumentRequest);

        $route = [
            $schoolYear,
            $student->Stage(),
            $student->Level(),
            $student->Group(),
            strtolower($classifyDocumentRequest->subject()),
            $classifyDocumentRequest->studentId(),
            $fileName
        ];
        return implode(DIRECTORY_SEPARATOR, $route);
    }

    public function computeNewFileName(ClassifyDocumentRequest $classifyDocumentRequest) : string
    {
        $timeStamp = $classifyDocumentRequest->dateTime()->format('Y-m-d');

        $extension = substr(strrchr($classifyDocumentRequest->path(), '.'), 1);

        return sprintf(
            '%s-%s.%s',
            $timeStamp,
            $classifyDocumentRequest->type(),
            $extension
        );
    }
}
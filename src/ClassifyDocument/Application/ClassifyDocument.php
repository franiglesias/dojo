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

        $route = [
            $schoolYear,
            $student->Stage(),
            $student->Level(),
            $student->Group()
        ];
        return implode(DIRECTORY_SEPARATOR, $route);
    }
}
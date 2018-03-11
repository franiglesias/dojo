<?php

namespace Tests\Dojo\ClassifyDocument\Application;

use DateTime;
use Dojo\ClassifyDocument\Application\ClassifyDocument;
use Dojo\ClassifyDocument\Application\ClassifyDocumentRequest;
use Dojo\ClassifyDocument\Application\SchoolYearCalculator;
use Dojo\ClassifyDocument\Domain\Student;
use Dojo\ClassifyDocument\Domain\StudentRepository;
use PHPUnit\Framework\TestCase;

class ClassifyDocumentAcceptanceTest extends TestCase
{
    private const DEFAULT_STUDENT_ID = '5433';
    private const DEFAULT_SUBJECT = 'Matemáticas';
    private const DEFAULT_TYPE = 'deberes';
    private const DEFAULT_FILE = 'misejercicioschupiguais.pdf';
    private const DEFAULT_UPLOAD_DATE = '2018-03-12';

    private const DEFAULT_SCHOOL_YEAR = '2017-2018';

    public function setUp()
    {
        $this->schoolYearCalculator = $this->prophesize(
            SchoolYearCalculator::class
        );
        $this->schoolYearCalculator
            ->forDate(new DateTime(self::DEFAULT_UPLOAD_DATE))
            ->willReturn(self::DEFAULT_SCHOOL_YEAR);

        $this->studentRepository = $this->prophesize(
            StudentRepository::class
        );

        $this->studentRepository->byId(self::DEFAULT_STUDENT_ID)
            ->willReturn(new Student(
                self::DEFAULT_STUDENT_ID,
                'Pepito',
                '5',
                'primaria',
                '5C'
            ));
        $this->classifyDocumentService = new ClassifyDocument(
            $this->schoolYearCalculator->reveal(),
            $this->studentRepository->reveal()
        );
    }

    public function testValidRequestShouldGenerateRoute()
    {
        $classifyDocumentRequest = new ClassifyDocumentRequest(
            self::DEFAULT_STUDENT_ID,
            self::DEFAULT_SUBJECT,
            self::DEFAULT_TYPE,
            self::DEFAULT_FILE,
            new DateTime(self::DEFAULT_UPLOAD_DATE)
        );
        $route = $this->classifyDocumentService->execute($classifyDocumentRequest);
        $expected = '2017-2018/primaria/5/5C/matemáticas/5433/2018-03-12-deberes.pdf';
        $this->assertEquals($expected, $route);
    }
}

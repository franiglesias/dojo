<?php

namespace Tests\Dojo\ClassifyDocument\Application;

use DateTime;
use Dojo\ClassifyDocument\Application\ClassifyDocument;
use Dojo\ClassifyDocument\Application\ClassifyDocumentRequest;
use Dojo\ClassifyDocument\Application\SchoolYearCalculator;
use Dojo\ClassifyDocument\Domain\Student;
use Dojo\ClassifyDocument\Domain\StudentRepository;
use PHPUnit\Framework\TestCase;

class ClassifyDocumentTest extends TestCase
{
    private $classifyDocumentService;
    private $schoolYearCalculator;
    private $studentRepository;

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

    public function testSchoolYearIsTheFirstFolderLevel()
    {
        $classifyDocumentRequest = new ClassifyDocumentRequest(
            self::DEFAULT_STUDENT_ID,
            self::DEFAULT_SUBJECT,
            self::DEFAULT_TYPE,
            self::DEFAULT_FILE,
            new DateTime(self::DEFAULT_UPLOAD_DATE)
        );

        $route = $this->classifyDocumentService->execute($classifyDocumentRequest);
        [$schoolYear] = explode('/', $route);
        $this->assertEquals(self::DEFAULT_SCHOOL_YEAR, $schoolYear);
    }

    public function testSchoolYearForFirstQuarterIsTheSameYear()
    {
        $uploadDate = '2018-10-12';
        $schoolYear = '2018-2019';

        $classifyDocumentRequest = new ClassifyDocumentRequest(
            self::DEFAULT_STUDENT_ID,
            self::DEFAULT_SUBJECT,
            self::DEFAULT_TYPE,
            self::DEFAULT_FILE,
            new DateTime($uploadDate)
        );

        $this->schoolYearCalculator->forDate(new DateTime($uploadDate))->willReturn($schoolYear);

        $route = $this->classifyDocumentService->execute($classifyDocumentRequest);

        [$schoolYear] = explode('/', $route);
        $this->assertEquals($schoolYear, $schoolYear);
    }

    public function testStageIstheSecondFolderLevel()
    {
        $expectedStage = 'primaria';

        $classifyDocumentRequest = new ClassifyDocumentRequest(
            self::DEFAULT_STUDENT_ID,
            self::DEFAULT_SUBJECT,
            self::DEFAULT_TYPE,
            self::DEFAULT_FILE,
            new DateTime(self::DEFAULT_UPLOAD_DATE)
        );

        $route = $this->classifyDocumentService->execute($classifyDocumentRequest);

        [, $stage] = explode('/', $route);
        $this->assertEquals($expectedStage, $stage);
    }

    public function testStageIstheSecondFolderLevelAndMayVary()
    {
        $expectedStage = 'secundaria';
        $studentId = 6745;

        $this->studentRepository->byId($studentId)
            ->willReturn(new Student(
                $studentId,
                'Pepito',
                '4',
                $expectedStage,
                '4C'
            ));

        $classifyDocumentRequest = new ClassifyDocumentRequest(
            $studentId,
            self::DEFAULT_SUBJECT,
            self::DEFAULT_TYPE,
            self::DEFAULT_FILE,
            new DateTime(self::DEFAULT_UPLOAD_DATE)
        );

        $route = $this->classifyDocumentService->execute($classifyDocumentRequest);

        [, $stage] = explode('/', $route);
        $this->assertEquals($expectedStage, $stage);
    }

    public function testlevelIstheThirdFolderLevel()
    {
        $classifyDocumentRequest = new ClassifyDocumentRequest(
            self::DEFAULT_STUDENT_ID,
            self::DEFAULT_SUBJECT,
            self::DEFAULT_TYPE,
            self::DEFAULT_FILE,
            new DateTime(self::DEFAULT_UPLOAD_DATE)
        );

        $route = $this->classifyDocumentService->execute($classifyDocumentRequest);

        [, , $level] = explode('/', $route);
        $this->assertEquals('5', $level);
    }

    public function testGroupIstheFourthFolderLevel()
    {
        $classifyDocumentRequest = new ClassifyDocumentRequest(
            self::DEFAULT_STUDENT_ID,
            self::DEFAULT_SUBJECT,
            self::DEFAULT_TYPE,
            self::DEFAULT_FILE,
            new DateTime(self::DEFAULT_UPLOAD_DATE)
        );

        $route = $this->classifyDocumentService->execute($classifyDocumentRequest);

        [, , , $group] = explode('/', $route);
        $this->assertEquals('5C', $group);
    }

    public function testSubjectIstheFifthFolderLevel()
    {
        $classifyDocumentRequest = new ClassifyDocumentRequest(
            self::DEFAULT_STUDENT_ID,
            self::DEFAULT_SUBJECT,
            self::DEFAULT_TYPE,
            self::DEFAULT_FILE,
            new DateTime(self::DEFAULT_UPLOAD_DATE)
        );

        $route = $this->classifyDocumentService->execute($classifyDocumentRequest);

        [, , , ,$subject] = explode('/', $route);
        $this->assertEquals('matemáticas', $subject);
    }

    public function testStudentIdIstheSixthFolderLevel()
    {
        $classifyDocumentRequest = new ClassifyDocumentRequest(
            self::DEFAULT_STUDENT_ID,
            self::DEFAULT_SUBJECT,
            self::DEFAULT_TYPE,
            self::DEFAULT_FILE,
            new DateTime(self::DEFAULT_UPLOAD_DATE)
        );

        $route = $this->classifyDocumentService->execute($classifyDocumentRequest);

        [, , , , , $studentId] = explode('/', $route);
        $this->assertEquals(self::DEFAULT_STUDENT_ID, $studentId);
    }

    public function testFileNameIstheSeventhFolderLevelAndHasTimeStamp()
    {
        $classifyDocumentRequest = new ClassifyDocumentRequest(
            self::DEFAULT_STUDENT_ID,
            self::DEFAULT_SUBJECT,
            self::DEFAULT_TYPE,
            self::DEFAULT_FILE,
            new DateTime(self::DEFAULT_UPLOAD_DATE)
        );

        $route = $this->classifyDocumentService->execute($classifyDocumentRequest);

        [, , , , , , $fileName] = explode('/', $route);
        $this->assertEquals('2018-03-12-deberes.pdf', $fileName);
    }

}

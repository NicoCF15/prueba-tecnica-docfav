<?php
namespace Tests\Infrastructure\Repository;

use App\Infrastructure\Repository\DoctrineUserRepository;
use App\Domain\Model\Entity\User;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Password;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;

class DoctrineTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private DoctrineUserRepository $userRepository;

    // Configuración de la base de datos de pruebas y EntityManager
    public function setUp(): void
    {
        // Configuración de la conexión a MySQL
        $connectionOptions = [
            'driver' => 'pdo_mysql',
            'host' => 'mysql_db', 
            'dbname' => 'prueba_tecnica_docfav_test',  
            'user' => 'root',
            'password' => 'MKdjWl$29#MD4&l5kw2?', 
            'port' => 3306, 
        ];

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [realpath(__DIR__ . "/../../src/Domain/Model/Entity")], 
            isDevMode: true
        );

        $connection = DriverManager::getConnection($connectionOptions, $config);
        $this->entityManager = new EntityManager($connection, $config);

        //create test database
        $schemaTool = new SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($classes);

        $this->userRepository = new DoctrineUserRepository($this->entityManager);
    }

    public function testSaveUser()
    {
        $name = new Name('Luciano');
        $email = new Email('luciano.larama.vendeta@example.com');
        $password = new Password('M1C0ntras3niaS3gur4#/');

        $user = new User($name, $email, $password);

        $this->userRepository->save($user);

        $savedUser = $this->userRepository->findByEmail($email);
        $this->assertNotNull($savedUser);
        $this->assertEquals($email, $savedUser->getEmail());
    }

    public function testUserRepositoryCanSaveAndFindUser(): void
    {
        $name = new Name("Luciano");
        $email = new Email("luciano.larama.vendeta@example.com");
        $password = new Password("M1C0ntras3niaS3gur4#/'");

        // Crear la entidad User
        $user = new User($name, $email, $password);

        $this->userRepository->save($user);

        // Verificar que el usuario fue guardado correctamente
        $savedUser = $this->userRepository->findByEmail($email);
        $this->assertNotNull($savedUser);
        $this->assertEquals($email, $savedUser->getEmail());

        // Eliminar el usuario de la base de datos para limpiar
        $this->userRepository->delete($user->getId());

        // Verificar que el usuario fue eliminado
        $deletedUser = $this->userRepository->findById($user->getId());
        $this->assertNull($deletedUser);
    }

    // Limpieza de la base de datos después de cada prueba
    protected function tearDown(): void
    {
        // Eliminar la base de datos de prueba
        $schemaTool = new SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($classes);

        // Cerrar el EntityManager
        $this->entityManager->close();
    }
}

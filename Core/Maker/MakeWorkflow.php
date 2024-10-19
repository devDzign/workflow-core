<?php

declare(strict_types=1);

namespace InterInvest\Workflow\Core\Maker;

use InterInvest\Workflow\Core\Handler\EventMessageInterface;
use InterInvest\Workflow\Core\Workflow\WorkflowInterface;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\MakerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Filesystem\Filesystem;

class MakeWorkflow implements MakerInterface
{
    public static function getCommandName(): string
    {
        return 'make:ii-workflow';
    }

    public static function getCommandDescription(): string
    {
        return 'Génère une classe Workflow et une classe Activity avec Symfony Maker';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->addArgument('domain', InputArgument::REQUIRED, 'Le nom du domaine (e.g. Finance)')
            ->addArgument('workflowName', InputArgument::REQUIRED, 'Le nom du workflow')
            ->addArgument('activityName', InputArgument::REQUIRED, 'Le nom de l\'activité');
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        // Récupération des données d'entrée
        $domain = $input->getArgument('domain');
        $nameWorkflow = $input->getArgument('workflowName');
        $nameActivity = $input->getArgument('activityName');
        $nameWorkflowLower = strtolower($nameWorkflow);

        // Chemins des dossiers
        $baseDir = sprintf('src/%s/Activity', $domain);
        $workflowDir = sprintf('src/%s/Workflow', $domain);

        // Initialiser le système de fichiers
        $filesystem = new Filesystem();

        // Créer les dossiers
        $filesystem->mkdir([$baseDir, $workflowDir]);

        // Contenu du fichier Workflow PHP
        $workflowClassContent = <<<PHP
        <?php

        declare(strict_types=1);

        namespace App\\$domain\\Workflow;

        use InterInvest\Workflow\Core\Handler\EventMessageInterface;
        use InterInvest\Workflow\Core\Workflow\WorkflowInterface;
        use InterInvest\Workflow\Core\Workflow\AbstractWorkflow;
        use App\\$domain\\Activity\\{$nameActivity}Activity;


        /**
         * @implements WorkflowInterface<string>
         */
        class {$nameWorkflow}Workflow extends AbstractWorkflow
        {
            public const string WORKFLOW_NAME = 'workflow.{$nameWorkflowLower}';
            
            

            public function start(EventMessageInterface \$eventMessage): string
            {
                // Implémentation du workflow ici
              
                return  \$this->make({$nameActivity}Activity::class)->execute();
            }
            
            public static function supportedEvent(): string
            {
                 return self::WORKFLOW_NAME;
            }
        }

        PHP;

        // Chemin du fichier Workflow PHP
        $workflowFile = sprintf('%s/%sWorkflow.php', $workflowDir, $nameWorkflow);

        // Créer le fichier avec le contenu Workflow
        $filesystem->dumpFile($workflowFile, $workflowClassContent);

        // Contenu du fichier Activity PHP
        $activityClassContent = <<<PHP
        <?php

        declare(strict_types=1);

        namespace App\\$domain\\Activity;

        use InterInvest\Workflow\Core\Activity\AbstractActivity;

        class {$nameActivity}Activity extends AbstractActivity
        {
            public function execute(): string
            {
                return 'Your logic activity here '.__CLASS__;
            }
        }

        PHP;

        // Chemin du fichier Activity PHP
        $activityFile = sprintf('%s/%sActivity.php', $baseDir, $nameActivity);

        // Créer le fichier avec le contenu Activity
        $filesystem->dumpFile($activityFile, $activityClassContent);

        // Confirmation pour l'utilisateur
        $io->success(sprintf('Le workflow "%s" et l\'activité "%s" ont été générés avec succès dans le domaine "%s".', $nameWorkflow, $nameActivity, $domain));
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        // Ajouter des dépendances si nécessaire
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command): void
    {
        // TODO: Implement interact() method.
    }
}

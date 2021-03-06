<?php

namespace Maarsson\Repository\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Maarsson\Repository\Traits\UsesFolderConfigTrait;
use Maarsson\Repository\Traits\UsesStubFunctionsTrait;

class MakeRepositoryCommand extends Command
{
    use UsesFolderConfigTrait, UsesStubFunctionsTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository
        {model : The model class name eg.: \'YourModel\' or \'Foo\\Bar\'}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold model repository';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->setModelName()
            ->makeRepositoryInterface()
            ->makeRepository()
            ->makeEvents()
            ->makeListeners()
            ->warnIfModelNotExists()
            ->warnIfModelNotConfigured();
    }

    /**
     * Creates a repository interface.
     *
     * @return self
     */
    protected function makeRepositoryInterface(): self
    {
        $this->makeClass('RepositoryInterface', $this->getInterfacesFolder());

        return $this;
    }

    /**
     * Creates a repository.
     *
     * @return self
     */
    protected function makeRepository(): self
    {
        $this->makeClass('Repository', $this->getRepositoriesFolder());

        return $this;
    }

    /**
     * Creates events classes.
     *
     * @return self
     */
    protected function makeEvents(): self
    {
        $this->makeClass('IsCreatingEvent', $this->getEventsFolder());
        $this->makeClass('IsDeletingEvent', $this->getEventsFolder());
        $this->makeClass('IsUpdatingEvent', $this->getEventsFolder());
        $this->makeClass('WasCreatedEvent', $this->getEventsFolder());
        $this->makeClass('WasDeletedEvent', $this->getEventsFolder());
        $this->makeClass('WasUpdatedEvent', $this->getEventsFolder());

        return $this;
    }

    /**
     * Creates listeners classes.
     *
     * @return self
     */
    protected function makeListeners(): self
    {
        $this->makeClass('IsCreatingListener', $this->getListenersFolder());
        $this->makeClass('IsDeletingListener', $this->getListenersFolder());
        $this->makeClass('IsUpdatingListener', $this->getListenersFolder());
        $this->makeClass('WasCreatedListener', $this->getListenersFolder());
        $this->makeClass('WasDeletedListener', $this->getListenersFolder());
        $this->makeClass('WasUpdatedListener', $this->getListenersFolder());

        return $this;
    }

    /**
     * Gets the converted stub template content.
     *
     * @param string $stub
     *
     * @return string
     */
    protected function getConvertedStubContent(string $stub): string
    {
        return Str::replace(
            [
                '{{modelName}}',
                '{{modelsNamespace}}',
                '{{interfacesNamespace}}',
                '{{repositoriesNamespace}}',
                '{{eventsNamespace}}',
                '{{listenersNamespace}}',
            ],
            [
                $this->modelBaseName,
                $this->getModelsNamespaceWithoutTrailingSlash() . $this->modelNamespaceSuffix,
                $this->getInterfacesNamespaceWithoutTrailingSlash() . $this->modelNamespaceSuffix,
                $this->getRepositoriesNamespaceWithoutTrailingSlash() . $this->modelNamespaceSuffix,
                $this->getEventsNamespaceWithoutTrailingSlash() . $this->modelNamespaceSuffix,
                $this->getListenersNamespaceWithoutTrailingSlash() . $this->modelNamespaceSuffix,
            ],
            $this->getStub($stub)
        );
    }
}

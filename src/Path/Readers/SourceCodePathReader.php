<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Path\Readers;

use hanneskod\classtools\Iterator\ClassIterator;
use Symfony\Component\Finder\Finder;

class SourceCodePathReader
{
    public function getExistingPaths(array $paths): array
    {
        $existingPaths = [];

        foreach ($paths as $path) {
            if (false === $path->isSourceCode()) {
                continue;
            }

            $list = $this->getDirectories($path->getPathBase());

            foreach ($list as $item) {
                if (true === empty($path->getClassBase())) {
                    $name = $item->getRelativePathname();
                } else {
                    $name = $path->getClassBase().$item->getRelativePathname();
                }

                $existingPaths[] = str_replace('/', '\\', $name);
            }
        }

        return $existingPaths;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getExistingClasses(array $paths): array
    {
        $namespaceList = [];
        $classList     = [];
        $list          = [];
        foreach ($paths as $path) {
            if (false === $path->isSourceCode()) {
                continue;
            }
            $iter = new ClassIterator($this->getPhpFiles($path->getPathBase()));

            foreach (array_keys($iter->getClassMap()) as $classname) {
                if (in_array(substr($classname, -4), ['Test', 'Spec'])) {
                    continue;
                }

                try {
                    $reflection = new \ReflectionClass($classname);
                } catch (\Throwable $exception) {
                    continue;
                }

                if ($reflection->isAbstract() || $reflection->isTrait() || $reflection->isInterface()) {
                    continue;
                }

                if ($reflection->inNamespace()) {
                    $namespaces = explode('\\', $reflection->getNamespaceName());

                    $namespace = '';
                    foreach ($namespaces as $key => $namespacePart) {
                        if ($namespace !== '') {
                            $namespace .= '/';
                        }
                        $namespace .= $namespacePart;

                        if (!array_key_exists($key, $namespaceList)) {
                            $namespaceList[$key] = [];
                        }

                        $namespaceList[$key][$namespace] = $namespace;
                    }
                }

                $escapedName = str_replace('\\', '/', $classname);

                $classList[$escapedName] = $escapedName;
            }
        }

        foreach ($namespaceList as $namespaceDepthList) {
            $list = array_merge($list, $namespaceDepthList);
        }

        $list = array_merge($list, $classList);

        return $list;
    }

    protected function getDirectories($path)
    {
        $finder = new Finder();

        return $finder->directories()->in($path);
    }

    protected function getPhpFiles($path)
    {
        $finder = new Finder();

        return $finder->files()->in($path)->name('*.php');
    }
}

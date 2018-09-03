<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/9/1
 * Time: 下午6:38
 */

namespace Cly\generator;


class Generator
{
    protected $name;

    protected $config = [
        'migration_path' => '',
        'model_path' => '',
        'resource_path' => '',
        'controller_path' => '',
        'routes_path' => '',
        'vue_pages_path' => '',
        'vue_routes_path' => '',
    ];

    public function __construct()
    {
        $packagePath = dirname(dirname(__DIR__));
        $this->config['migration_path'] = $packagePath . '/database/migrations';
        $this->config['model_path'] = $packagePath . '/src/Model';
        $this->config['resource_path'] = $packagePath . '/src/Http/Resources';
        $this->config['controller_path'] = $packagePath . '/src/Http/Controllers/Admin';
        $this->config['routes_path'] = $packagePath . '/routes/admin.php';
        $this->config['vue_pages_path'] = $packagePath . '/resource/assets/js/admin/pages';
        $this->config['vue_api_path'] = $packagePath . '/resource/assets/js/api.js';
        $this->config['vue_routes_path'] = $packagePath . '/resource/assets/js/admin/router.js';
    }

    public function build($name)
    {
        $this->name = $name;
        $this->buildMigration();
        $this->buildModel();
        $this->buildResource();
        $this->buildController();
        $this->buildRoutes();
        $this->buildVueIndexPage();
        $this->buildVueCreatePage();
        $this->buildVueUpdatePage();
        $this->buildVueApi();
        $this->buildVueRoutes();
    }

    public function buildMigration()
    {
        $name = $this->name;
        $distPath = $this->config['migration_path'];
        $filename = $distPath . '/' . '2019_01_01_000000_create_' . $name . '_table.php';
        $stubPath = __DIR__ . '/stub/migration.stub';

        $className = 'Create' . ucfirst(camel_case($name)) . 'Table';
        $tableName = str_plural($name);

        $content = file_get_contents($stubPath);
        $content = str_replace(['#class_name#', '#table_name#'], [$className, $tableName], $content);
        file_put_contents($filename, $content);
    }

    public function buildModel()
    {
        $name = $this->name;
        $distPath = $this->config['model_path'];
        $filename = $distPath . '/' . ucfirst(camel_case($name)) . '.php';
        $stubPath = __DIR__ . '/stub/model.stub';

        $className = ucfirst(camel_case($name));

        $content = file_get_contents($stubPath);
        $content = str_replace(['#class_name#'], [$className], $content);
        file_put_contents($filename, $content);
    }

    public function buildResource()
    {
        $name = $this->name;
        $distPath = $this->config['resource_path'];
        $filename = $distPath . '/' . ucfirst(camel_case($name)) . 'Resource.php';
        $stubPath = __DIR__ . '/stub/resource.stub';

        $className = ucfirst(camel_case($name)) . 'Resource';

        $content = file_get_contents($stubPath);
        $content = str_replace(['#class_name#'], [$className], $content);
        file_put_contents($filename, $content);
    }

    public function buildController()
    {
        $name = $this->name;
        $distPath = $this->config['controller_path'];
        $filename = $distPath . '/' . ucfirst(camel_case($name)) . 'Controller.php';
        $stubPath = __DIR__ . '/stub/controller.stub';

        $className = ucfirst(camel_case($name)) . 'Controller';
        $modelName = ucfirst(camel_case($name));
        $resourceName = ucfirst(camel_case($name)) . 'Resource';

        $content = file_get_contents($stubPath);
        $content = str_replace([
            '#class_name#', '#model_name#', '#resource_name#'
        ], [
            $className, $modelName, $resourceName
        ], $content);
        file_put_contents($filename, $content);
    }

    public function buildRoutes()
    {
        $name = $this->name;
        $distPath = $this->config['routes_path'];
        $stubPath = __DIR__ . '/stub/routes.stub';

        $replaceStr = '        #replace_routes#';
        $prefix = substr($replaceStr, 0, strpos($replaceStr, '#'));
        $controllerName = ucfirst(camel_case($name)) . 'Controller';

        $replaceContent = file_get_contents($stubPath);
        $replaceContent = str_replace([
            '#name#', '#controller_name#'
        ], [
            $name, $controllerName
        ], $replaceContent);

        $replaceContent = preg_replace('/(.*\n)/', $prefix . '$1', $replaceContent);
        $replaceContent .= PHP_EOL . $replaceStr;

        $content = file_get_contents($distPath);
        $content = preg_replace("/#${name}_routes#(.|\n)*#${name}_routes#\s*(?=#)/", '', $content);
        $content = str_replace($replaceStr, $replaceContent, $content);
        file_put_contents($distPath, $content);
    }

    public function buildVueIndexPage()
    {
        $name = $this->name;
        $distPath = $this->config['vue_pages_path'] . '/' . $name;
        if (!file_exists($distPath)) {
            mkdir($distPath, 0777, true);
        }
        $distFile = $distPath . '/Index.vue';
        $stubPath = __DIR__ . '/stub/vue/index.stub';

        $indexName = $name . '_index';
        $apiList = 'admin' . ucfirst(camel_case($name)) . 'Index';
        $apiUpdate = 'admin' . ucfirst(camel_case($name)) . 'Update';
        $apiDelete = 'admin' . ucfirst(camel_case($name)) . 'Delete';
        $routeCreate = camel_case($name) . 'Create';
        $routeUpdate = camel_case($name) . 'Update';

        $content = file_get_contents($stubPath);
        $content = str_replace([
            '#indexName#', '#apiList#', '#apiUpdate#', '#apiDelete#', '#routeCreate#', '#routeUpdate#'
        ], [
            $indexName, $apiList, $apiUpdate, $apiDelete, $routeCreate, $routeUpdate
        ], $content);
        file_put_contents($distFile, $content);
    }

    public function buildVueCreatePage()
    {
        $name = $this->name;
        $distPath = $this->config['vue_pages_path'] . '/' . $name;
        if (!file_exists($distPath)) {
            mkdir($distPath, 0777, true);
        }
        $distFile = $distPath . '/Create.vue';
        $stubPath = __DIR__ . '/stub/vue/create.stub';

        $createName = $name . '_create';
        $apiCreate = 'admin' . ucfirst(camel_case($name)) . 'Create';
        $routeIndex = camel_case($name) . 'Index';

        $content = file_get_contents($stubPath);
        $content = str_replace([
            '#createName#', '#apiCreate#', '#routeIndex#',
        ], [
            $createName, $apiCreate, $routeIndex,
        ], $content);
        file_put_contents($distFile, $content);
    }

    public function buildVueUpdatePage()
    {
        $name = $this->name;
        $distPath = $this->config['vue_pages_path'] . '/' . $name;
        if (!file_exists($distPath)) {
            mkdir($distPath, 0777, true);
        }
        $distFile = $distPath . '/Update.vue';
        $stubPath = __DIR__ . '/stub/vue/update.stub';

        $updateName = $name . '_update';
        $apiDetail = 'admin' . ucfirst(camel_case($name)) . 'Detail';
        $apiUpdate = 'admin' . ucfirst(camel_case($name)) . 'Update';
        $routeIndex = camel_case($name) . 'Index';

        $content = file_get_contents($stubPath);
        $content = str_replace([
            '#updateName#', '#apiDetail#', '#apiUpdate#', '#routeIndex#',
        ], [
            $updateName, $apiDetail, $apiUpdate, $routeIndex,
        ], $content);
        file_put_contents($distFile, $content);
    }

    public function buildVueApi()
    {
        $name = $this->name;
        $distPath = $this->config['vue_api_path'];
        $stubPath = __DIR__ . '/stub/vue/api.stub';

        $replaceStr = '    //replace_api';
        $prefix = substr($replaceStr, 0, strpos($replaceStr, '//'));

        $routeName = ucfirst(camel_case($name));
        $urlName = $name;
        $replaceContent = file_get_contents($stubPath);
        $replaceContent = str_replace([
            '#name#', '#route_name#', '#url_name#'
        ], [
            $name, $routeName, $urlName
        ], $replaceContent);

        $replaceContent = preg_replace('/(.*\n)/', $prefix . '$1', $replaceContent);
        $replaceContent .= PHP_EOL . $replaceStr;

        $content = file_get_contents($distPath);
        $content = preg_replace("/\/\/admin_${name}_api(.|\n)*\/\/admin_${name}_api\s*(?=\/)/", '', $content);
        $content = str_replace($replaceStr, $replaceContent, $content);
        file_put_contents($distPath, $content);
    }

    public function buildVueRoutes()
    {
        $name = $this->name;
        $distPath = $this->config['vue_routes_path'];
        $stubPath = __DIR__ . '/stub/vue/routes.stub';

        $replaceStr = '                //replace_routes';
        $prefix = substr($replaceStr, 0, strpos($replaceStr, '//'));

        $routeName = camel_case($name);
        $pathName = $name;
        $pagePath = $name;
        $replaceContent = file_get_contents($stubPath);
        $replaceContent = str_replace([
            '#name#', '#route_name#', '#path_name#', '#page_path#'
        ], [
            $name, $routeName, $pathName, $pagePath
        ], $replaceContent);

        $replaceContent = preg_replace('/(.*\n)/', $prefix . '$1', $replaceContent);
        $replaceContent .= PHP_EOL . $replaceStr;

        $content = file_get_contents($distPath);
        $content = preg_replace("/\/\/${name}_routes(.|\n)*\/\/${name}_routes\s*(?=\/)/", '', $content);
        $content = str_replace($replaceStr, $replaceContent, $content);
        file_put_contents($distPath, $content);
    }
}
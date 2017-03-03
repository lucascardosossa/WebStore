<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 2/4/17
 * Time: 6:51 PM
 */


namespace app\controllers;

use Yii;


class FeatureController extends MainController
{
    public $freeAccess = true;
    private $webRoot = "C:/xampp/htdocs/";

    public function actionFeatureConfiguration()
    {
        $this->layout = 'feature-selection';
        if (!empty(Yii::$app->request->post())) {
            $this->commonFeatures(Yii::$app->request->post('productName'));
            //var_dump(Yii::$app->request->post());
        }
        return $this->render('feature');
    }

    private function commonFeatures($productName)
    {
        $basePath = Yii::getAlias('@webroot') . '/../';
        $destinationFolder = $this->webRoot . $productName;
        $folders = ['assets', 'commands', 'config', 'controllers', 'mail', 'models', 'runtime', 'tests', 'views', 'web'];
        $subFolder = ['web' => ['assets', 'css', 'plugins']];
        $files = [
            'assets' => [
                'AppAsset'
            ],
            'commands' => [
                'HelloController'
            ],
            'config' => [
                'console', 'db', 'params', 'test', 'test_db', 'web'
            ],
            'controllers' => [
                'ProductController'
            ],
            'models' => [
                'Product', 'ProductSearch'
            ],
            'web' => [
                '.htaccess', 'favicon.ico', 'index.php', 'index-test.php', 'robots.txt'
            ],
            '.' => [
                '.bowerrc', '.gitignore', '.htaccess', 'codeception.yml', 'composer.json',
                'composer.lock', 'LICENSE.md', 'README.md', 'requirements.php', 'yii', 'yii.bat'
            ]
        ];
        if (!is_dir($destinationFolder)) {
            /*CRIA A PASTA RAIZ*/
            mkdir($destinationFolder);
            /*CRIA PASTAS*/
            foreach ($folders as $folder) {
                mkdir($destinationFolder . '/' . $folder);
            }
            /*CRIA SUBPASTAS*/
            foreach ($subFolder as $key => $item) {
                foreach ($item as $sub) {
                    mkdir($destinationFolder . '/' . $key . '/' . $sub);
                }
            }
            /*COPIA OS ARQUIVOS PARA DENTRO DA PASTAS CORRESPONDENTES*/
            foreach ($files as $folder => $arrFiles) {
                if ($folder != '.' && $folder != "web") {
                    foreach ($arrFiles as $file) {
                        copy($basePath . $folder . '/' . $file . '.php', $destinationFolder . '/' . $folder . '/' . $file . '.php');
                    }
                } else {
                    foreach ($arrFiles as $file) {
                        copy($basePath . $folder . '/' . $file, $destinationFolder . '/' . $folder . '/' . $file);
                    }
                }
            }
        }
    }


}
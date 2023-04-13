<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use linslin\yii2\curl;
use app\models\Fruits;
use GuzzleHttp\Client;
use Yii;
/**
 * This command fetches all the fruits from https://fruityvice.com/ and save in database.
 *
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FruitsController extends Controller
{

    /**
     * Fetches all fruits from https://fruityvice.com/ and saves them to the database
     * 
     * @return int Exit code
     * 
     * @throws Exception If there is an error saving the fruits to the database
     */
    public function actionFetch(): int
    {
        $client = new Client();
        $baseUrl = env('FRUITYVICE_BASE_URL');
        $allFruitsEndPoint = $baseUrl . env('FRUITYVICE_ALL_FRUITS');

        $response = $client->request('GET', $allFruitsEndPoint);

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody(), true);

            foreach ($data as $fruitData) {
                $fruit = Fruits::findOne(['name' => $fruitData['name']]);

                if (!$fruit) {
                    $fruit = new Fruits();
                    $fruit->name = $fruitData['name'];
                }

                $fruit->family = $fruitData['family'];
                $fruit->genus = $fruitData['genus'];
                $fruit->order = $fruitData['order'];
                $fruit->nutritions = json_encode($fruitData['nutritions']);
                $fruit->save();
            }

            //$this->sendEmail();
            
            echo "All fruits have been fetched and saved to the database successfully.\n";
            return ExitCode::OK;
        } else {
            echo "Failed to fetch fruits from API.\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

    private function sendEmail(): void
    {
        $message = Yii::$app->mailer->compose()
                ->setFrom('your_email@gmail.com')
                ->setTo('test@example.com')
                ->setSubject('Fruits fetched successfully')
                ->setTextBody('All fruits have been successfully fetched and saved to the database.')
                ->send();
    }
}

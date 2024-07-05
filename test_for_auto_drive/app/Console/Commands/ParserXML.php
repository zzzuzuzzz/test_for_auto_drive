<?php

namespace App\Console\Commands;

use App\Models\Offer;
use Illuminate\Console\Command;
use SimpleXMLElement;
use XMLReader;

class ParserXML extends Command
{

    protected $signature = 'app:parser {--url=default}';
    protected $description = 'Парсер данных из XML файла';


    public function handle()
    {
        $option = $this->option('url');
        $filePath = storage_path('app/data.xml');
        if ($option !== 'default') {
            $filePath = storage_path($option);
        }

        $xmlReader = new XMLReader();
        try {
            $xmlReader->open($filePath);
        } catch (\ErrorException) {
            $this->info('Не удалось открыть файл. Запуск дефолтного файла');
            $xmlReader->open(storage_path('app/data.xml'));
        }


        $this->info('Начало загрузки данных');
        $result = [];

        while ($xmlReader->read()) {
            if ($xmlReader->nodeType == XMLReader::ELEMENT) {
                $tag = $xmlReader->name;

                switch ($tag) {

                    case 'offer':
                        $node = new SimpleXMLElement($xmlReader->readOuterXML());
                        $result = [
                            'id' => $node->id,
                            'mark' => $node->mark,
                            'model' => $node->model,
                            'generation' => $node->generation,
                            'year' => $node->year,
                            'run' => $node->run,
                            'color' => $node->color,
                            'body-type' => 'body-type',
                            'engine-type' => 'engine-type',
                            'transmission' => $node->transmission,
                            'gear-type' => 'gear-type',
                            'generation_id' => $node->generation_id,
                            'verified' => 1
                        ];
                        break;

                    case 'body-type':
                        $result['body-type'] = $xmlReader->readInnerXml();
                        break;

                    case 'engine-type':
                        $result['engine-type'] = $xmlReader->readInnerXml();
                        break;

                    case 'gear-type':
                        $result['gear-type'] = $xmlReader->readInnerXml();
                        Offer::updateOrCreate(
                            ['id' => $result['id']],
                            $result
                        );
                        $result = [];
                        break;
                }
            }
        }

        Offer::where('verified', 0)->delete();
        Offer::where('verified', 1)->update(['verified' => 0]);

        $this->info('Данные успешно сохранены');
    }
}

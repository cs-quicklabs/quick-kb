<?php
    namespace App\Http\Controllers;

    use App\Services\OgImageGenerator as OgImageGenerator;
    class OgImageController extends Controller
    {
        

        public function ogImageGenerate()  {
            $image = cache()->rememberForever('articles.1234.ogimage', function () {
                return (new OgImageGenerator())->render(
                    view('ogimage.ogimage')->with(['article' => "This is a test article"])->render()
                );
            });
    
            return response($image)
                ->header('Content-Type', 'image/png');
        }
    }
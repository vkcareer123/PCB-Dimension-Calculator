<?php

namespace App\Http\Controllers;

use App\Services\Gerber\GerberParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ZipArchive;

class GerberController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function upload(Request $request, GerberParser $parser)
    {
        $request->validate([
            'gerber' => 'required|file|mimes:zip|max:1024',
            ], [
                'gerber.required' => 'Please select Gerber ZIP file.',
                'gerber.file'     => 'Uploaded file is not valid.',
                'gerber.mimes'    => 'Only ZIP files are allowed.',
                'gerber.max'      => 'File size must be less than 1 MB.',
            ]);

        $directory = storage_path('app/gerbers/' . uniqid());

        File::makeDirectory($directory, 0777, true);

        try {

            $zip = new ZipArchive();

            if ($zip->open($request->file('gerber')->getRealPath()) !== true) {
                throw new \Exception('Unable to open ZIP file.');
            }

            $zip->extractTo($directory);
            $zip->close();

            $dimensions = $parser->parse($directory);

            return redirect()
            ->route('result')
            ->with('dimensions', $dimensions);
        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
        finally {

            // Remove extracted files after processing
            File::deleteDirectory($directory);
             
        }
    }

    public function result()
    {
        $dimensions = session('dimensions');

        if (!$dimensions) {
            return redirect('/');
        }

        return view('result', compact('dimensions'));
    }
}
<?php

namespace Nurix\NurixBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NurixBundle:Default:index.html.twig', array('name' => $name));
    }

    public function uploadFileAction(Request $request){

        if ($request->isMethod('POST')) {
                $file = $request->files->get('upload');
                $extension = $file->guessExtension();
            if(in_array($extension,array('jpg','jpeg','png'))){
                    $baseurl = $request->getBasePath();
                    $dir = $this->get('kernel')->getRootDir() . '/../web/upload/ckimages';
                    $filename = sha1(uniqid(mt_rand(), true));
                    $filename = $filename . '.' . $extension;
                    $file->move($dir, $filename);

                    $result = $this->SendCKEditorResults(0,$request->query->get('CKEditorFuncNum'),$baseurl."/upload/ckimages/".$filename,$filename);

                    return new Response($result);
                }
        }
    }
    function SendCKEditorResults ($errorNumber, $CKECallback, $fileUrl, $fileName, $customMsg ='')
    {
        $result ="";
        // Minified version of the document.domain automatic fix script (#1919).
        // The original script can be found at _dev/domain_fix_template.js
        $result .= <<<EOF
<script type="text/javascript">
(function(){var d=document.domain;while (true){try{var A=window.parent.document.domain;break;}catch(e) {};d=d.replace(/.*?(?:\.|$)/,'');if (d.length==0) break;try{document.domain=d;}catch (e){break;}}})();
EOF;

        if ($errorNumber && $errorNumber != 201) {
            $fileUrl = "";
            $fileName= "";
        }

        $msg = "";

        switch ($errorNumber )
        {
            case 0 :
                $msg = "Upload successful";
                break;
            case 1 :	// Custom error.
                $msg = $customMsg;
                break ;
            case 201 :
                $msg = 'A file with the same name is already available. The uploaded file has been renamed to "' . $fileName . '"' ;
                break ;
            case 202 :
                $msg = 'Invalid file' ;
                break ;
            default :
                $msg = 'Error on file upload. Error number: ' + $errorNumber ;
                break ;
        }

        $rpl = array( '\\' => '\\\\', '"' => '\\"' ) ;
        $result .= 'window.parent.CKEDITOR.tools.callFunction("'. $CKECallback. '","'. strtr($fileUrl, $rpl). '", "'. strtr( $msg, $rpl). '");' ;

        $result .= '</script>';
        return $result;
    }
}

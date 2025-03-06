<?php
    use App\Models\KnowledgeBase;
    use Illuminate\Support\Facades\Auth;
    /**
     * Truncates a string to a specified length and appends a suffix if needed
     * 
     * @param string $string The input string to be shortened
     * @param int $length Maximum length of the output string (default: 20)
     * @param string $append String to append if truncation occurs (default: "...")
     * @return string Shortened string with append string if truncated
     */
    if (!function_exists('getShortTitle')) {
        function getShortTitle($string, $length = 20, $append = "...")
        {
            return (strlen($string) > $length) ? substr($string, 0, $length) . $append : $string;
        }
    }

    if(!function_exists('getLoggedInUser')){
        function getLoggedInUser() {
            $userData = [];
            $user = Auth::user();
            if(!empty($user)){
                $knowledgeBase = $user->knowledgeBase;
                if(!empty($knowledgeBase)){
                    $knowledgeBaseTheme = $knowledgeBase->theme;
                    if(!empty($knowledgeBaseTheme)){
                        $theme = json_decode($knowledgeBaseTheme->theme??"{}", true); 
                    }
                }
            }

            $userData['user'] = $user ?? [];
            $userData['knowledgeBase'] = $knowledgeBase ?? [];
            $userData['themeData'] = $theme ?? [];
            return $userData;
        }
    }


    if(!function_exists('getKnowledgeBase')){
        function getKnowledgeBase() {
            $knowledgeBase = KnowledgeBase::first();
            return $knowledgeBase->knowledge_base_name??"Knowledge_base_name";
        }
    }
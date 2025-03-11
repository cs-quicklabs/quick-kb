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


    /**
     * Retrieves the currently logged-in user, along with their associated knowledge base and theme data
     * 
     * @return array An array containing the user's data, their knowledge base, and the theme data
     */
    if(!function_exists('getLoggedInUser')){
        function getLoggedInUser() {
            $userData = [];
            if(Auth::check()){
                $user = Auth::user();
                $knowledgeBase = $user->knowledgeBase;
                if(!empty($knowledgeBase)){
                    $knowledgeBaseTheme = $knowledgeBase->theme;

                    if(!empty($knowledgeBaseTheme)){
                        $theme = $knowledgeBaseTheme->theme_data;
                        
                    }
                }
                $userData['user'] = $user ?? [];
                $userData['knowledgeBase'] = $knowledgeBase ?? [];
                $userData['themeData'] = $theme ?? [];
            }
            
            return $userData;
        }
    }

    /**
     * Retrieves the name of the knowledge base from the database
     *
     * @return string The name of the knowledge base if found, otherwise "Knowledge_base_name"
     */
    if(!function_exists('getKnowledgeBase')){ 
        function getKnowledgeBase() {
            $knowledgeBase = KnowledgeBase::first();
            return $knowledgeBase->knowledge_base_name??"Knowledge_base_name";
        }
    }
    
    

    /**
     * Returns the default theme data for a knowledge base
     *
     * This function returns the default theme data for a knowledge base,:
     * - color: 'blue'
     * - color_hash: '#1A56DB'
     * - hover_color: 'blue'
     * - hover_color_hash: '#1E429F'
     * - theme_spacing: 'default'
     * - theme_type: 'default'
     *
     * @return array An array containing the default theme data
     */
    if(!function_exists('getDefaultThemeValues')){ 
        function getDefaultThemeValues() {
            $themeData = [
                'color' => 'blue',
                'color_hash' => '#1A56DB',
                'hover_color' => 'blue',
                'hover_color_hash' => '#1E429F',
                'theme_spacing' => 'default',
                'theme_type' => 'default'
            ]; 

            return $themeData;
        }
    }
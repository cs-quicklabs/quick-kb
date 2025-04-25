<?php
    use App\Models\KnowledgeBase;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Theme;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Facades\Schema;

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
                        $theme = $knowledgeBaseTheme->theme;
                        
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


    /**
     * Returns the content without any HTML tags and without any Base64-encoded images
     * 
     * @param string $content The content to clean
     * @return string The cleaned content
     */
    if(!function_exists('getCleanContent')){ 
        function getCleanContent($content = "") {
            // Remove Base64-encoded images
            // $content = preg_replace('/<img[^>]+src="data:image\/[^;]+;base64,[^"]+"[^>]*>/i', '', $content);
            // Remove all HTML tags
            return strip_tags($content);
        }
    }



    /**
     * Returns the theme data from the database
     * 
     * @return array An array containing the theme data
     * 
     * The theme data is an array with the following keys:
     * - color: The color of the theme
     * - color_hash: The hex color code of the theme
     * - hover_color: The color of the theme when hovered
     * - hover_color_hash: The hex color code of the theme when hovered
     * - theme_spacing: The spacing of the theme
     * - theme_type: The type of the theme
     * 
     * If no theme data is found in the database, the function returns the default theme data
     */
    if(!function_exists('getThemeValues')){ 
        function getThemeValues() {
            $defaultThemeData = getDefaultThemeValues();

            // Get theme values from cookies
            $themeData = json_decode(Cookie::get('themeData'), true);

            if(!empty($themeData)){
                return $themeData;
            }


            // For SQLite: check if the DB file exists
            if (config('database.default') === 'sqlite') {
                $sqlitePath = config('database.connections.sqlite.database');
                $sqlitePath = database_path(basename($sqlitePath));
                
                if (!file_exists($sqlitePath)) {
                    $themeData = $defaultThemeData;
                    // Store in cookies
                    Cookie::queue('themeData', json_encode($themeData), 60 * 24 * 30);
                    return $themeData;
                }
            }


            if(Schema::hasTable('themes')){
                // Check if the theme table exists
                $themeData = Theme::first();
                if(empty($themeData)){
                    $themeData = $defaultThemeData;
                } else {
                    $themeData = $themeData->theme;
                }
            } else {
                // If the theme table does not exist, use default theme data
                $themeData = $defaultThemeData;
            }

            // Store in cookies
            Cookie::queue('themeData', json_encode($themeData), 60 * 24 * 30);
            return $themeData;
        }
    }
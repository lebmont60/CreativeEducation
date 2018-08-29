<?php
    class Helpers
    {
        public static function cleanFirstname($firstname)
        {
            return ucfirst(mb_strtolower($firstname));
        }

        public static function cleanLastname($lastname)
        {
            return mb_strtoupper($lastname);
        }

        public static function europeanDateFormat($date)
        {
            $date = substr($date, 0, 10);

            return date('d/m/Y', strtotime($date));
        }

        public static function get_include_contents($filename, $variablesToMakeLocal)
        {
            extract($variablesToMakeLocal);

            if(is_file($filename))
            {
                ob_start();
                include $filename;
                return ob_get_clean();
            }

            return false;
        }
        
                public static function listCourseCategoryTableDropdown()
        {
            //récupération de toutes les catégories
            $course_category = new Course_category();
            $categories = $course_category->getAll();

            //création d'un tableau à fournir au modal
            $arrayCategories = [];

            foreach($categories as $category)
            {

                //récupération du nombre de cours liés à la category
                $queryConditions = [
                    "select"=>[
                        "course_category.*"
                    ],
                    "join"=>[
                        "inner_join"=>[],
                        "left_join"=>[],
                        "right_join"=>[]
                    ],
                    "where"=>[
                        "clause"=>"`status` = '1'",
                        "and"=>[],
                        "or"=>[]
                    ],
                    "and"=>[
                        [
                            "clause"=>"",
                            "and"=>[],
                            "or"=>[]
                        ]
                    ],
                    "or"=>[
                        [
                            "clause"=>"",
                            "and"=>[],
                            "or"=>[]
                        ]
                    ],
                    "group_by"=>[],
                    "having"=>[
                        "clause"=>"",
                        "and"=>[],
                        "or"=>[]
                    ],
                    "order_by"=>[
                        "asc"=>[],
                        "desc"=>[]
                    ],
                    "limit"=>[
                        "offset"=>"",
                        "range"=>""
                    ]
                ];

                $idCategory = $category->getId();
                $arrayCategories[$idCategory]['name'] = $category->getName();
            }
            return $arrayCategories;
        }
    }
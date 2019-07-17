<?php

namespace AppBundle\Service;

class QueryService
{
    /**
     * @param array $params
     * @return string
     */
    public function buildWhere(array $params)
    {
        $j = 0;
        $tablesLen = count($params["tables"]);
        $whereStr = "";
        foreach ($params["tables"] as $table => $fields){
            $termsLen = count($params["searchTerms"]);
            $t = 0;
            foreach ($params["searchTerms"] as $searchTerm){
                $fieldsLen = count($fields);
                end($params["tables"]);
                $i = 0;
                foreach ($fields as $field){
                    end($fields);
                    $whereStr .= " " . $table . '.' . $field . " LIKE '%" . $searchTerm ."%'";
                    $i++;
                    if ($i < $fieldsLen){
                        $whereStr .= " OR";
                    }
                }

                $t++;
                if ($t < $termsLen){
                    $whereStr .= " OR";
                }
            }

            $j++;
            if ($j < $tablesLen){
                $whereStr .= " OR";
            }
        }

        return $whereStr;
    }
}

# doctrine-search
A service that build the "where" part of a doctrine query to search for a term in specified tables and columns.

Usage:

Get the data from the request and split the search term into an array.
The params array has a "tables" array where the alias of the table to search in is the key of each element.
It has an array of the fields to check.
Add the search terms array.
Add more more parameters to use in your custom query.

    $params = [];
    $string = $data["searchTerm"];
    $params["tables"] = [
        'e' => ["field_1", "field_2", "field_3"],
        's' => ["field_1", "field_2"]
    ];
    $params["searchTerms"] = explode(' ', $string);

    $result = $this->getDoctrine()->getRepository("AppBundle:Entity")->getAll($params);


Before fetching the results from the query check if there are search terms set in the params.
If so create an instance of the service and call the buildWhere function with the params array.

    $qb = $this->getEntityManager()->createQueryBuilder();
    $qb->select('e')
        ->from("AppBundle:Entity", 'e')
        ->join("e.something", 's');

    if (isset($params["searchTerms"]) && "" != $params["searchTerms"]){
        $queryService = new QueryService();
        $whereStr = $queryService->buildWhere($params);
        $qb->where($whereStr);
    }

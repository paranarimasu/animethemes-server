<?php

namespace Tests\Unit\JsonApi\Condition;

use App\Enums\Filter\BinaryLogicalOperator;
use App\Enums\Filter\ComparisonOperator;
use App\JsonApi\Condition\Condition;
use App\JsonApi\QueryParser;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrashedConditionTest extends TestCase
{
    use WithFaker;

    /**
     * By default, the Trashed Condition shall be scoped globally.
     *
     * @return void
     */
    public function testGlobalScope()
    {
        $condition = Condition::make('trashed', $this->faker->word());

        $this->assertEmpty($condition->getScope());
    }

    /**
     * The Trashed Condition shall parse scope from the query.
     *
     * @return void
     */
    public function testScope()
    {
        $scope = $this->faker->word();

        $parameters = [
            QueryParser::PARAM_FILTER => [
                $scope => [
                    'trashed' => $this->faker->word(),
                ],
            ],
        ];

        $parser = QueryParser::make($parameters);

        $condition = collect($parser->getConditions('trashed'))->first();

        $this->assertEquals($scope, $condition->getScope());
    }

    /**
     * The Trashed Condition shall parse the field from the query.
     *
     * @return void
     */
    public function testField()
    {
        $parameters = [
            QueryParser::PARAM_FILTER => [
                'trashed' => $this->faker->word(),
            ],
        ];

        $parser = QueryParser::make($parameters);

        $condition = collect($parser->getConditions('trashed'))->first();

        $this->assertEquals('trashed', $condition->getField());
    }

    /**
     * The Trashed Condition shall not parse the comparison operator.
     *
     * @return void
     */
    public function testComparisonOperator()
    {
        $operator = ComparisonOperator::getRandomInstance();

        $parameters = [
            QueryParser::PARAM_FILTER => [
                'trashed' => [
                    $operator->key => $this->faker->word(),
                ],
            ],
        ];

        $parser = QueryParser::make($parameters);

        $condition = collect($parser->getConditions('trashed'))->first();

        $this->assertNull($condition->getComparisonOperator());
    }

    /**
     * The Trashed Condition shall not parse the logical operator.
     *
     * @return void
     */
    public function testLogicalOperator()
    {
        $operator = BinaryLogicalOperator::getRandomInstance();
        $default = BinaryLogicalOperator::fromValue(BinaryLogicalOperator::AND);

        $parameters = [
            QueryParser::PARAM_FILTER => [
                'trashed' => [
                    $operator->key => $this->faker->word(),
                ],
            ],
        ];

        $parser = QueryParser::make($parameters);

        $condition = collect($parser->getConditions('trashed'))->first();

        $this->assertEquals($default, $condition->getLogicalOperator());
    }
}
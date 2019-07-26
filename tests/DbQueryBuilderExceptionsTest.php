<?php


use DB\DBQueryAction;
use DB\DbQueryBuilder;
use PHPUnit\Framework\TestCase;

class DbQueryBuilderExceptionsTest extends TestCase
{
    public function testNoActionAndTableNameException()
    {
        $queryBuilder = new DbQueryBuilder();
        $this->expectExceptionMessage(DbQueryBuilder::EXCEPTION_NO_ACTION_AND_TABLE_NAME);
        $queryBuilder->build();
    }

    public function testTruncateTableNoNeedConditionSentenceException(): void
    {
        $queryBuilder = new DbQueryBuilder();
        $queryBuilder
            ->truncateTable('test')
            ->setConditionSentence('test sentence');
        $this->expectExceptionMessage(sprintf(
            DbQueryBuilder::EXCEPTION_NO_NEED_CONDITION_SENTENCE,
            DBQueryAction::TRUNCATE_TABLE));
        $queryBuilder->build();
    }

    public function testInsertIntoNoNeedConditionSentenceException(): void
    {
        $queryBuilder = new DbQueryBuilder();
        $queryBuilder
            ->insertInto('test')
            ->addParam('test_param')
            ->setConditionSentence('test sentence');
        $this->expectExceptionMessage(sprintf(
            DbQueryBuilder::EXCEPTION_NO_NEED_CONDITION_SENTENCE,
            DBQueryAction::INSERT_INTO));
        $queryBuilder->build();
    }

    public function testReplaceIntoNoNeedConditionSentenceException(): void
    {
        $queryBuilder = new DbQueryBuilder();
        $queryBuilder
            ->replaceInto('test')
            ->addParam('test_param')
            ->setConditionSentence('test sentence');
        $this->expectExceptionMessage(sprintf(
            DbQueryBuilder::EXCEPTION_NO_NEED_CONDITION_SENTENCE,
            DBQueryAction::REPLACE_INTO));
        $queryBuilder->build();
    }

    public function testInsertIntoMustHaveParamListException(): void
    {
        $queryBuilder = new DbQueryBuilder();
        $queryBuilder
            ->insertInto('test');
        $this->expectExceptionMessage(sprintf(
            DbQueryBuilder::EXCEPTION_MUST_HAVE_PARAM_LIST,
            DBQueryAction::INSERT_INTO));
        $queryBuilder->build();
    }

    public function testReplaceIntoMustHaveParamListException(): void
    {
        $queryBuilder = new DbQueryBuilder();
        $queryBuilder
            ->replaceInto('test');
        $this->expectExceptionMessage(sprintf(
            DbQueryBuilder::EXCEPTION_MUST_HAVE_PARAM_LIST,
            DBQueryAction::REPLACE_INTO));
        $queryBuilder->build();
    }

    public function testUpdateTableMustHaveParamListException(): void
    {
        $queryBuilder = new DbQueryBuilder();
        $queryBuilder
            ->updateTable('test');
        $this->expectExceptionMessage(sprintf(
            DbQueryBuilder::EXCEPTION_MUST_HAVE_PARAM_LIST,
            DBQueryAction::UPDATE));
        $queryBuilder->build();
    }
}
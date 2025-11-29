<?php

namespace Tests\Unit\Services\AI;

use App\Models\AiModel;
use App\Models\Cluster;
use App\Models\Spot;
use App\Services\AI\TaskSelector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskSelectorTest extends TestCase
{
    use RefreshDatabase;

    private TaskSelector $taskSelector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskSelector = new TaskSelector;
    }

    public function test_select_a_type_tasks_returns_spots_with_priority(): void
    {
        // Arrange: スポットを作成
        $cluster = Cluster::factory()->create();

        $spotHigh = Spot::factory()->create(['analysis_priority' => 3]);
        $spotMed = Spot::factory()->create(['analysis_priority' => 2]);
        $spotLow = Spot::factory()->create(['analysis_priority' => 1]);

        // Act: Aタイプタスクを選定
        $tasks = $this->taskSelector->selectATypeTasks();

        // Assert: 優先度の高い順に取得されること
        $this->assertGreaterThan(0, $tasks->count());
        $this->assertEquals(3, $tasks->first()->analysis_priority);
    }

    public function test_select_a_type_tasks_excludes_already_analyzed_spots(): void
    {
        // Arrange: 分析済みスポットを作成
        $model = AiModel::factory()->create();
        $analyzedSpot = Spot::factory()->create([
            'analysis_priority' => 3,
            'detail_analyzed_by_model_id' => $model->id,
        ]);

        $unanalyzedSpot = Spot::factory()->create([
            'analysis_priority' => 3,
            'detail_analyzed_by_model_id' => null,
        ]);

        // Act
        $tasks = $this->taskSelector->selectATypeTasks();

        // Assert: 未分析のスポットのみ取得されること
        $this->assertFalse($tasks->contains($analyzedSpot));
        $this->assertTrue($tasks->contains($unanalyzedSpot));
    }

    public function test_select_b_type_task_respects_task_dependencies(): void
    {
        // Arrange: スポットリストアップが完了したクラスター
        $model = AiModel::factory()->create();
        $cluster = Cluster::factory()->create([
            'spot_listing_analyzed_by_model_id' => $model->id,
        ]);

        // Act: Bタイプタスクを選定
        $task = $this->taskSelector->selectBTypeTask();

        // Assert: スポット優先度付けタスクが選定されること
        $this->assertNotNull($task);
        $this->assertEquals('spot_priority', $task['type']);
        $this->assertEquals($cluster->id, $task['cluster']->id);
    }

    public function test_select_task_type_returns_a_type_or_b_type(): void
    {
        // Act: タスクタイプを複数回選定
        $results = [];
        for ($i = 0; $i < 100; $i++) {
            $results[] = $this->taskSelector->selectTaskType();
        }

        // Assert: a_type と b_type が両方返されること
        $this->assertContains('a_type', $results);
        $this->assertContains('b_type', $results);
    }

    public function test_select_available_model_returns_enabled_model(): void
    {
        // Arrange: 有効なモデルを作成
        $enabledModel = AiModel::factory()->create([
            'enabled' => true,
            'performance_priority' => 1,
        ]);

        $disabledModel = AiModel::factory()->create([
            'enabled' => false,
            'performance_priority' => 0,
        ]);

        // Act
        $selectedModel = $this->taskSelector->selectAvailableModel();

        // Assert: 有効なモデルが選定されること
        $this->assertNotNull($selectedModel);
        $this->assertEquals($enabledModel->id, $selectedModel->id);
    }
}

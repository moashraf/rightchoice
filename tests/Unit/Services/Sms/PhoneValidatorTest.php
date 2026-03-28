<?php

namespace Tests\Unit\Services\Sms;

use App\Services\Sms\PhoneValidator;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the PhoneValidator service.
 *
 * Tests phone number normalization and validation for Egyptian mobile numbers.
 */
class PhoneValidatorTest extends TestCase
{
    // ─── Valid numbers ──────────────────────────────────────────────────

    public function test_valid_vodafone_number(): void
    {
        $result = PhoneValidator::validate('01012345678');
        $this->assertTrue($result['valid']);
        $this->assertEquals('01012345678', $result['normalized']);
        $this->assertNull($result['reason']);
    }

    public function test_valid_etisalat_number(): void
    {
        $result = PhoneValidator::validate('01112345678');
        $this->assertTrue($result['valid']);
    }

    public function test_valid_orange_number(): void
    {
        $result = PhoneValidator::validate('01212345678');
        $this->assertTrue($result['valid']);
    }

    public function test_valid_we_number(): void
    {
        $result = PhoneValidator::validate('01512345678');
        $this->assertTrue($result['valid']);
    }

    // ─── Normalization ──────────────────────────────────────────────────

    public function test_normalize_with_country_code_20(): void
    {
        $result = PhoneValidator::validate('201012345678');
        $this->assertTrue($result['valid']);
        $this->assertEquals('01012345678', $result['normalized']);
    }

    public function test_normalize_with_prefix_002(): void
    {
        $result = PhoneValidator::validate('002010123456789');
        // After normalization: 010123456789 (12 digits — invalid, should be 11)
        // This depends on exact number; let's test a correct one
        $result2 = PhoneValidator::validate('00201012345678');
        $this->assertTrue($result2['valid']);
        $this->assertEquals('01012345678', $result2['normalized']);
    }

    public function test_normalize_with_spaces_and_dashes(): void
    {
        $result = PhoneValidator::validate('010-1234-5678');
        $this->assertTrue($result['valid']);
        $this->assertEquals('01012345678', $result['normalized']);
    }

    public function test_normalize_with_plus(): void
    {
        $result = PhoneValidator::validate('+201012345678');
        $this->assertTrue($result['valid']);
        $this->assertEquals('01012345678', $result['normalized']);
    }

    // ─── Invalid numbers ────────────────────────────────────────────────

    public function test_null_phone(): void
    {
        $result = PhoneValidator::validate(null);
        $this->assertFalse($result['valid']);
        $this->assertNotNull($result['reason']);
    }

    public function test_empty_string(): void
    {
        $result = PhoneValidator::validate('');
        $this->assertFalse($result['valid']);
    }

    public function test_too_short_number(): void
    {
        $result = PhoneValidator::validate('0101234');
        $this->assertFalse($result['valid']);
    }

    public function test_landline_number(): void
    {
        $result = PhoneValidator::validate('0225551234');
        $this->assertFalse($result['valid']);
    }

    public function test_invalid_operator_prefix(): void
    {
        $result = PhoneValidator::validate('01312345678');
        $this->assertFalse($result['valid']);
    }

    // ─── isValid shorthand ──────────────────────────────────────────────

    public function test_isValid_returns_true_for_valid(): void
    {
        $this->assertTrue(PhoneValidator::isValid('01012345678'));
    }

    public function test_isValid_returns_false_for_invalid(): void
    {
        $this->assertFalse(PhoneValidator::isValid('abc'));
    }
}

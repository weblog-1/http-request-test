# coding: utf-8
require 'bundler'
Bundler.require
require 'minitest/autorun'
require 'json'

# request test
class TestStubRequest < Minitest::Test
  def setup
    @client = Faraday.new
  end

  def test_normal_request
    response = @client.get('http://weblog-1.github.io/')
    assert(response.body.include?('<title>si dimentica subito</title>'))
    assert_equal('text/html; charset=utf-8', response.headers['Content-Type'])
  end

  def test_stub_request
    client = stub_client
    response = client.get('http://weblog-1.github.io/')
    parsed = JSON.parse(response.body)
    assert(parsed.is_a?(Hash))
    assert_equal('OK', parsed['test'])
    assert_equal('application/json', response.headers['Content-Type'])
  end

  private

  def stub_client
    Faraday.new do |connection|
      connection.adapter :test, Faraday::Adapter::Test::Stubs.new do |stub|
        stub.get('http://weblog-1.github.io/') do
          [200, { 'Content-Type' => 'application/json' }, '{"test":"OK"}']
        end
      end
    end
  end
end

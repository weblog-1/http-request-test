# coding: utf-8
#
# for bundler
require 'bundler'
Bundler.require
require 'rake/testtask'
#
# for ActiveSupport::Dependencies
# require 'active_support/dependencies'
# ActiveSupport::Dependencies.autoload_paths << '/path/to/lib'
#
task :test do
  Rake::TestTask.new do |test|
    test.libs << 'tests'
    test.test_files = Dir['tests/**/test*.rb']
    test.verbose = true
  end
end

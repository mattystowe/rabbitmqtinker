<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{

  /**
   * Render the exception into an HTTP response.
   *
   * @param  \Illuminate\Http\Request
   * @return \Illuminate\Http\Response
   */
  public function render($request)
  {
      return response()->view('errors.usernotfoundexception', [], 404);
  }
}
